<?php namespace Anomaly\RelationshipFieldType;

use Anomaly\RelationshipFieldType\Command\BuildOptions;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class RelationshipFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
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
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.relationship::input';

    /**
     * The filter view.
     *
     * @var string
     */
    protected $filterView = 'anomaly.field_type.relationship::filter';

    /**
     * The field type config.
     *
     * @var array
     */
    protected $config = [
        'handler' => 'Anomaly\RelationshipFieldType\RelationshipFieldTypeOptions@handle'
    ];

    /**
     * The dropdown options.
     *
     * @var null|array
     */
    protected $options = null;

    /**
     * Get the relation.
     *
     * @return BelongsTo
     */
    public function getRelation()
    {
        $entry = $this->getEntry();

        return $entry->belongsTo(array_get($this->config, 'related'), $this->getColumnName());
    }

    /**
     * Get the related model.
     *
     * @return EloquentModel
     */
    public function getRelatedModel()
    {
        return app()->make(array_get($this->config, 'related'));
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
     * Get the placeholder.
     *
     * @return null|string
     */
    public function getPlaceholder()
    {
        return ($this->placeholder !== null) ? $this->placeholder : 'anomaly.field_type.relationship::input.placeholder';
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
