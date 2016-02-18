<?php namespace Anomaly\RelationshipFieldType;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

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

}