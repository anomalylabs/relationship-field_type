<?php

use Anomaly\RelationshipFieldType\Support\Config\RelatedHandler;

return [
    'related' => [
        'required' => true,
        'type'     => 'anomaly.field_type.select',
        'config'   => [
            'handler' => RelatedHandler::class,
        ],
    ],
    'mode'    => [
        'required' => true,
        'type'     => 'anomaly.field_type.select',
        'config'   => [
            'options' => [
                'dropdown' => 'anomaly.field_type.relationship::config.mode.option.dropdown',
                'lookup'   => 'anomaly.field_type.relationship::config.mode.option.lookup',
                'search'   => 'anomaly.field_type.relationship::config.mode.option.search',
            ],
        ],
    ],
];
