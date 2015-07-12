<?php

return [
    'related' => [
        'type'   => 'anomaly.field_type.select',
        'config' => [
            'options' => function (\Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface $streams) {

                $streams = $streams->all();

                $names = $streams->lists('name');

                $models = array_map(
                    function (\Anomaly\Streams\Platform\Stream\StreamModel $stream) {
                        return $stream->getEntryModelName();
                    },
                    $streams->all()
                );

                return array_combine($models, $names);
            }
        ]
    ]
];
