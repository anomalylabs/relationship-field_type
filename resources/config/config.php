<?php

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

return [
    'related' => [
        'required' => true,
        'type'     => 'anomaly.field_type.select',
        'config'   => [
            'options' => function (\Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface $streams) {

                $options = [];

                /* @var StreamInterface as $stream */
                foreach ($streams->all() as $stream) {
                    $options[ucwords(str_replace('_', ' ', $stream->getNamespace()))][$stream->getEntryModelName(
                    )] = $stream->getName();
                }

                foreach ($options as $namespace) {
                    ksort($namespace);
                }

                ksort($options);

                return $options;
            }
        ]
    ]
];
