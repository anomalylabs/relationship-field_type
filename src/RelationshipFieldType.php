<?php namespace Anomaly\RelationshipFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class RelationshipFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\RelationshipFieldType
 */
class RelationshipFieldType extends FieldType
{

    /**
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.relationship::input';

    /**
     * The options handler.
     *
     * @var string
     */
    protected $options = 'Anomaly\RelationshipFieldType\RelationshipFieldTypeOptions@handle';

    /**
     * Get the relation.
     *
     * @param EloquentModel $model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed|null
     */
    public function getRelation(EloquentModel $model)
    {
        return $model->belongsTo(array_get($this->config, 'related'), $this->getColumnName());
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return app()->call(array_get($this->config, 'handler', $this->options), ['fieldType' => $this]);
    }

    /**
     * Get the related model.
     *
     * @return EloquentModel
     */
    public function getRelatedModel()
    {
        return app()->make(array_get($this->config, 'related'));
    }

    /**
     * Get the database column name.
     *
     * @return null|string
     */
    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }
}
