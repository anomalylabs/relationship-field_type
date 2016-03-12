<?php namespace Anomaly\RelationshipFieldType;

use Anomaly\RelationshipFieldType\Command\BuildOptions;
use Anomaly\RelationshipFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class RelationshipFieldType
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\RelationshipFieldType
 */
class RelationshipFieldType extends FieldType
{

    use DispatchesJobs;

    /**
     * The underlying database column type
     *
     * @var string
     */
    protected $columnType = 'integer';

    /**
     * The filter view.
     *
     * @var string
     */
    protected $filterView = 'anomaly.field_type.relationship::filter';

    /**
     * The pre-defined handlers.
     *
     * @var array
     */
    protected $handlers = [
        'users'       => 'Anomaly\RelationshipFieldType\Handler\Users@handle',
        'fields'      => 'Anomaly\RelationshipFieldType\Handler\Fields@handle',
        'related'     => 'Anomaly\RelationshipFieldType\Handler\Related@handle',
        'assignments' => 'Anomaly\RelationshipFieldType\Handler\Assignments@handle'
    ];

    /**
     * The field type config.
     *
     * @var array
     */
    protected $config = [
        'handler' => 'related',
        'mode'    => 'dropdown'
    ];

    /**
     * The dropdown options.
     *
     * @var null|array
     */
    protected $options = null;

    /**
     * The cache repository.
     *
     * @var Repository
     */
    protected $cache;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new RelationshipFieldType instance.
     *
     * @param Repository $cache
     * @param Container  $container
     */
    public function __construct(Repository $cache, Container $container)
    {
        $this->cache     = $cache;
        $this->container = $container;
    }

    /**
     * Return the config key.
     *
     * @return string
     */
    public function key()
    {
        $this->cache->put(
            'anomaly/relationship-field_type::' . ($key = md5(json_encode($this->getConfig()))),
            $this->getConfig(),
            30
        );

        return $key;
    }

    /**
     * Value table.
     *
     * @return string
     */
    public function table()
    {
        /* @var ValueTableBuilder $table */
        $table = $this->container->make(ValueTableBuilder::class);

        $value = $this->getValue();

        if ($value instanceof EntryInterface) {
            $value = $value->getId();
        }

        return $table
            ->setConfig(new Collection($this->getConfig()))
            ->setModel($this->config('related'))
            ->setFieldType($this)
            ->setSelected($value)
            ->build()
            ->response()
            ->getTableContent();
    }

    /**
     * Get the relation.
     *
     * @return BelongsTo
     */
    public function getRelation()
    {
        $entry = $this->getEntry();
        $model = $this->getRelatedModel();

        return $entry->belongsTo(get_class($model), $this->getColumnName());
    }

    /**
     * Get the related model.
     *
     * @return EloquentModel
     */
    public function getRelatedModel()
    {
        return $this->container->make($this->config('related'));
    }

    /**
     * Get the dropdown options.
     *
     * @return array
     */
    public function getOptions()
    {
        if ($this->options === null) {
            $this->dispatch(new BuildOptions($this));
        }

        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get the pre-defined handlers.
     *
     * @return array
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * Get the placeholder.
     *
     * @return null|string
     */
    public function getPlaceholder()
    {
        return is_null($this->placeholder) ? 'anomaly.field_type.relationship::input.placeholder' : $this->placeholder;
    }

    /**
     * Return the input view.
     *
     * @return string
     */
    public function getInputView()
    {
        return 'anomaly.field_type.relationship::' . $this->config('mode');
    }

    /**
     * Get the database column name.
     *
     * @return null|string
     */
    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }

    /**
     * Get the column type.
     *
     * @return string
     */
    public function getColumnType()
    {
        return array_get($this->getConfig(), 'column_type', parent::getColumnType());
    }
}
