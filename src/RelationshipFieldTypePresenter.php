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
        if ($return = parent::__get($key)) {
            return $return;
        }

        if (!$related = $this->object->getValue()) {
            return null;
        }

        return self::$__decorator->decorate($related)->{$key};
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
        if ($return = parent::__call($method, $arguments)) {
            return $return;
        }

        if (!$related = $this->object->getValue()) {
            return null;
        }

        return call_user_func_array([self::$__decorator->decorate($related), $method], $arguments);
    }
}
