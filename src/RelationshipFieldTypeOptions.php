<?php namespace Anomaly\RelationshipFieldType;

use Anomaly\Streams\Platform\Model\EloquentModel;

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

        if (!$model instanceof EloquentModel) {
            return [];
        }

        $query = $model->newQuery();

        return $query->get()->lists(
            array_get($fieldType->getConfig(), 'title', $model->getTitleName()),
            array_get($fieldType->getConfig(), 'key', $model->getKeyName())
        );
    }
}
