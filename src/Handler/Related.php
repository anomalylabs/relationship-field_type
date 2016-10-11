<?php namespace Anomaly\RelationshipFieldType\Handler;

use Anomaly\RelationshipFieldType\RelationshipFieldType;

/**
 * Class Related
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class Related
{

    /**
     * Handle the options.
     *
     * @param  RelationshipFieldType $fieldType
     * @return array
     */
    public function handle(RelationshipFieldType $fieldType)
    {
        $model = $fieldType->getRelatedModel();

        $query = $model->newQuery();

        $fieldType->setOptions(
            $query->get()->pluck(
                $fieldType->config('title_name', $model->getTitleName()),
                $fieldType->config('key_name', $model->getKeyName())
            )->all()
        );
    }
}
