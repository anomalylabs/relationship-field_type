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

        $title = array_get($fieldType->getConfig(), 'title');
        $key   = array_get($fieldType->getConfig(), 'key');

        $fieldType->setOptions(
            array_filter(
                [null => $fieldType->getPlaceholder()] +
                $query->get()->lists(
                    $title ?: $model->getTitleName(),
                    $key ?: $model->getKeyName()
                )
            )
        );
    }
}
