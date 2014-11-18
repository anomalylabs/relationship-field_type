<?php namespace Anomaly\Streams\Addon\FieldType\Relationship;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

class RelationshipFieldType extends FieldType
{

    public function getRelation()
    {
        return $this->hasOne($this->getConfig('related'));
    }

    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }
}
