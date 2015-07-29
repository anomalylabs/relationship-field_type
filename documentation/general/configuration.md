# Configuration

**Example Definition:**

```
protected $fields = [
    'example' => [
        'type'   => 'anomaly.field_type.relationship',
        'config' => [
            'related' => 'Anomaly\UsersModule\User\UserModel',
            'handler' => 'Anomaly\UsersModule\User\UserOptions@handle',
        ]
    ]
];
```

### `related`

The namespaced related model

### `handler`

A handler to further process the options
