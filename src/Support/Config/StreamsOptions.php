<?php namespace Anomaly\RelationshipFieldType\Support\Config;

use Anomaly\SelectFieldType\SelectFieldType;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

class StreamsOptions
{

    /**
     * Handle the select options.
     *
     * @param      SelectFieldType            $fieldType  The field type
     * @param      StreamRepositoryInterface  $streams    The streams
     */
    public function handle(
        SelectFieldType $fieldType,
        StreamRepositoryInterface $streams
    )
    {
        $options = [];

        /* @var StreamInterface as $stream */
        foreach ($streams->visible() as $stream) {
            array_set(
                $options,
                ucwords(
                    str_replace('_', ' ', $stream->getNamespace())
                ).'.'.$stream->getEntryModelName(),
                $stream->getName()
            );
        }

        foreach ($options as $namespace) {
            ksort($namespace);
        }

        ksort($options);

        $fieldType->setOptions($options);
    }
}
