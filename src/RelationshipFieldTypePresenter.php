<?php namespace Anomaly\RelationshipFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;

/**
 * Class RelationshipFieldTypePresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\RelationshipFieldType
 */
class RelationshipFieldTypePresenter extends FieldTypePresenter
{

    /**
     * Fallback to getting attributes
     * off the related value.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        try {
            return parent::__get($key);
        } catch (\Exception $e) {

            if (!$related = $this->object->getValue()) {
                return null;
            }

            return $related->{$key};
        }
    }

    /**
     * Fallback to calling methods
     * on the related value.
     *
     * @param string $method
     * @param array  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        try {
<<<<<<< Updated upstream
            return parent::__call($method, $arguments);
        } catch (\Exception $e) {

            if (!$related = $this->object->getValue()) {
                return null;
            }
=======
            if ($return = parent::__call($method, $arguments)) {
                return $return;
            }
        } catch (\Exception $e) {
            if ($related = $this->object->getValue()) {
                if ($return = call_user_func_array([self::__getDecorator()->decorate($related), $method], $arguments)) {
                    return $return;
                }
            }
        }
>>>>>>> Stashed changes

            return call_user_func_array([$related, $method], $arguments);
        }
    }
}
