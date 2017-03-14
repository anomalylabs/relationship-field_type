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
                foreach ($streams->visible() as $stream) {
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
    ],
    'mode'    => [
        'required' => true,
        'type'     => 'anomaly.field_type.select',
        'config'   => [
            'options' => [
                'dropdown' => 'anomaly.field_type.relationship::config.mode.option.dropdown',
                'lookup'   => 'anomaly.field_type.relationship::config.mode.option.lookup',
                'search'   => 'anomaly.field_type.relationship::config.mode.option.search',
            ]
        ]
    ]
];
