<?php namespace Anomaly\RelationshipFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class RelationshipFieldTypeModifier
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\RelationshipFieldType
 */
class RelationshipFieldTypeModifier extends FieldTypeModifier
{

    /**
     * The field type instance.
     * This is for IDE support.
     *
     * @var RelationshipFieldType
     */
    protected $fieldType;

    /**
     * Restore the value.
     *
     * @param $value
     * @return null|EloquentModel
     */
    public function restore($value)
    {
        if (is_numeric($value)) {

            $relation = $this->fieldType->getRelatedModel();

            return $relation->find($value);
        }

        return $value;
    }
}
