<?php namespace Anomaly\RelationshipFieldType\Handler;

use Anomaly\RelationshipFieldType\RelationshipFieldType;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class Fields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\RelationshipFieldType
 */
class Fields
{

    /**
     * Handle the options.
     *
     * @param RelationshipFieldType     $fieldType
     * @param FieldRepositoryInterface  $fields
     * @param StreamRepositoryInterface $streams
     * @return array
     */
    public function handle(
        RelationshipFieldType $fieldType,
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams
    ) {
        $stream    = array_get($fieldType->getConfig(), 'stream');
        $unlocked  = array_get($fieldType->getConfig(), 'unlocked');
        $namespace = array_get($fieldType->getConfig(), 'namespace');

        $fields = $fields->findAllByNamespace($namespace);

        if ($stream && $stream = $streams->findBySlugAndNamespace($stream, $namespace)) {
            $fields = $fields->assignedTo($stream);
        }

        if ($unlocked) {
            $fields = $fields->unlocked();
        }

        $fieldType->setOptions(
            array_combine(
                $fields->lists('id')->toArray(),
                $fields->lists('name')->toArray()
            )
        );
    }
}
