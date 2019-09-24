<?php namespace Anomaly\RelationshipFieldType;

use Anomaly\RelationshipFieldType\Handler\Related;
use Anomaly\RelationshipFieldType\Table\LookupTableBuilder;
use Anomaly\RelationshipFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class RelationshipFieldTypeServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RelationshipFieldTypeServiceProvider extends AddonServiceProvider
{

    /**
     * The singleton bindings.
     *
     * @var array
     */
    protected $singletons = [
        RelationshipFieldTypeModifier::class => RelationshipFieldTypeModifier::class,
    ];

    /**
     * The addon routes.
     *
     * @var array
     */
    protected $routes = [
        'streams/relationship-field_type/index/{key}'    => 'Anomaly\RelationshipFieldType\Http\Controller\LookupController@index',
        'streams/relationship-field_type/selected/{key}' => 'Anomaly\RelationshipFieldType\Http\Controller\LookupController@selected',
    ];

    /**
     * Register the addon.
     *
     * @param EloquentModel $model
     */
    public function register(EloquentModel $model)
    {
        $model->bind(
            'new_relationship_field_type_lookup_table_builder',
            function () {
                if ($this instanceof EntryInterface) {
                    $builder = $this->getBoundModelNamespace() . '\\Support\\RelationshipFieldType\\LookupTableBuilder';

                    if (class_exists($builder)) {
                        return app($builder);
                    }
                }

                return app(LookupTableBuilder::class);
            }
        );

        $model->bind(
            'new_relationship_field_type_value_table_builder',
            function () {
                if ($this instanceof EntryInterface) {
                    $builder = $this->getBoundModelNamespace() . '\\Support\\RelationshipFieldType\\ValueTableBuilder';

                    if (class_exists($builder)) {
                        return app($builder);
                    }
                }

                return app(ValueTableBuilder::class);
            }
        );

        $model->bind(
            'get_relationship_field_type_options_handler',
            function () {
                if ($this instanceof EntryInterface) {
                    $handler = $this->getBoundModelNamespace() . '\\Support\\RelationshipFieldType\\OptionsHandler';

                    if (class_exists($handler)) {
                        return $handler;
                    }
                }

                return Related::class;
            }
        );
    }
}
