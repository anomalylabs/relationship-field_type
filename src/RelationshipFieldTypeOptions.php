<?php namespace Anomaly\RelationshipFieldType;

/**
 * Class RelationshipFieldTypeOptions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\RelationshipFieldType
 */
class RelationshipFieldTypeOptions
{

    /**
     * Handle the options.
     *
     * @param RelationshipFieldType $fieldType
     * @return array
     */
    public function handle(RelationshipFieldType $fieldType)
    {
        $model = $fieldType->getRelatedModel();

        $query = $model->newQuery();

        $fieldType->setOptions(
            array_filter(
                [null => $fieldType->getPlaceholder()] +
                $query->get()->lists(
                    $model->getTitleName(),
                    $model->getKeyName()
                )->all()
            )
        );
    }
}
