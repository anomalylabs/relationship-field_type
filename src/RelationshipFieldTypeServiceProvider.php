<?php namespace Anomaly\RelationshipFieldType;

use Anomaly\RelationshipFieldType\Command\GetLookupTable;
use Anomaly\RelationshipFieldType\Table\LookupTableBuilder;
use Anomaly\RelationshipFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Illuminate\Contracts\Container\Container;

/**
 * Class RelationshipFieldTypeServiceProvider
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\RelationshipFieldType
 */
class RelationshipFieldTypeServiceProvider extends AddonServiceProvider
{

    /**
     * The singleton bindings.
     *
     * @var array
     */
    protected $singletons = [
        'Anomaly\RelationshipFieldType\RelationshipFieldTypeModifier' => 'Anomaly\RelationshipFieldType\RelationshipFieldTypeModifier'
    ];

    /**
     * The addon routes.
     *
     * @var array
     */
    protected $routes = [
        'streams/relationship-field_type/index/{key}'    => 'Anomaly\RelationshipFieldType\Http\Controller\LookupController@index',
        'streams/relationship-field_type/selected/{key}' => 'Anomaly\RelationshipFieldType\Http\Controller\LookupController@selected'
    ];

    /**
     * Register the addons.
     *
     * @param EntryModel $model
     */
    public function register(EntryModel $model)
    {
        $model->bind(
            'new_relationship_field_type_lookup_table_builder',
            function (Container $container) {

                $builder = $this->getBoundModelNamespace() . '\\Support\\RelationshipFieldType\\LookupTableBuilder';

                if (class_exists($builder)) {
                    return $container->make($builder);
                }

                return $container->make(LookupTableBuilder::class);
            }
        );

        $model->bind(
            'new_relationship_field_type_value_table_builder',
            function (Container $container) {

                $builder = $this->getBoundModelNamespace() . '\\Support\\RelationshipFieldType\\ValueTableBuilder';

                if (class_exists($builder)) {
                    return $container->make($builder);
                }

                return $container->make(ValueTableBuilder::class);
            }
        );
    }

}