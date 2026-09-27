<?php namespace Anomaly\RelationshipFieldType\Handler;

use Anomaly\RelationshipFieldType\RelationshipFieldType;
use Anomaly\Streams\Platform\Support\Value;

/**
 * Class Related
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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

        $query   = $model->newQuery();
        $results = $query->get();

        $titleName = $fieldType->config('title_name', $model->getTitleName()) ?: $model->getTitleName();
        $keyName   = $fieldType->config('key_name', $model->getKeyName()) ?: $model->getKeyName();

        /**
         * The label is a column name or a {field} pattern. A hidden
         * attribute and a full Twig expression (which would reach any
         * attribute through the presenter) are both refused - fall
         * back to the title.
         */
        if (in_array($titleName, $model->getHidden(), true)
            || preg_match('/\{\{|\{%/', $titleName)
        ) {
            $titleName = $model->getTitleName();
        }

        try {

            /**
             * Try and use a non-parsing pattern.
             */
            if (strpos($titleName, '{') === false) {
                $fieldType->setOptions(
                    $results
                        ->pluck(
                            $titleName,
                            $keyName
                        )
                        ->all()
                );
            }

            /**
             * Try and use a parsing pattern.
             */
            if (strpos($titleName, '{') !== false) {
                $fieldType->setOptions(
                    array_combine(
                        $results->map(
                            function ($item) use ($keyName) {
                                return data_get($item, $keyName);
                            }
                        )->all(),
                        $results->map(
                            function ($item) use ($titleName, $value) {
                                return $value->make($titleName, $item);
                            }
                        )->all()
                    )
                );
            }
        } catch (\Exception $e) {
            $fieldType->setOptions(
                $results->pluck(
                    $model->getTitleName(),
                    $model->getKeyName()
                )->all()
            );
        }
    }
}
