# Configuration

**Example Definition:**

```
protected $fields = [
    'example' => [
        'type'   => 'anomaly.field_type.relationship',
        'config' => [
            'related' => 'Anomaly\UsersModule\User\UserModel',
            'handler' => 'Anomaly\RelationshipFieldType\RelationshipFieldTypeOptions@handle',
        ]
    ]
];
```

### `related`

The class string of the related model.

### `handler`

The options handler callable string. Any valid callable class string can be used. The default value is `'Anomaly\RelationshipFieldType\RelationshipFieldTypeOptions@handle'`.

The handler is responsible for setting the available options on the field type instance.

**NOTE:** This option can not be set through the GUI configuration. 
