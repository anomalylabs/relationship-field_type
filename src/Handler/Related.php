<?php namespace Anomaly\RelationshipFieldType\Handler;

use Anomaly\RelationshipFieldType\RelationshipFieldType;
use Anomaly\Streams\Platform\Support\Value;

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
     * @param Value $value
     * @return array
     */
    public function handle(RelationshipFieldType $fieldType, Value $value)
    {
        $model = $fieldType->getRelatedModel();

        $query = $model->newQuery();

        try {

            /**
             * Try and use a non-parsing pattern.
             */
            if (strpos($fieldType->config('title_name', $model->getTitleName()), '{') === false) {
                $fieldType->setOptions(
                    $query->get()->pluck(
                        $fieldType->config('title_name', $model->getTitleName()),
                        $fieldType->config('key_name', $model->getKeyName())
                    )->all()
                );
            }

            /**
             * Try and use a parsing pattern.
             */
            if (strpos($fieldType->config('title_name', $model->getTitleName()), '{') !== false) {

                $results = $query->get();

                $fieldType->setOptions(
                    array_combine(
                        $results->map(
                            function ($item) use ($fieldType, $model) {
                                return data_get($item, $fieldType->config('key_name', $model->getKeyName()));
                            }
                        )->all(),
                        $results->map(
                            function ($item) use ($fieldType, $model, $value) {
                                return $value->make($fieldType->config('title_name', $model->getTitleName()), $item);
                            }
                        )->all()
                    )
                );
            }
        } catch (\Exception $e) {
            $fieldType->setOptions(
                $query->get()->pluck(
                    $model->getTitleName(),
                    $model->getKeyName()
                )->all()
            );
        }
    }
}
