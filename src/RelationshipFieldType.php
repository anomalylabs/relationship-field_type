<?php namespace Anomaly\Streams\Addon\FieldType\Relationship;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

class RelationshipFieldType extends FieldTypeAddon
{
    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }
}
