# Relationship Field Type

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Output](#output)


<a name="introduction"></a>
## Introduction

`anomaly.field_type.relationship`

The relationship field type provides an HTML select input with options from a related Stream or model.

### Usage

Simply set the related entry in order to associate it.

    $entry->example = $related;

You may also use the relation method that is automatically compiled on the model.

    $entry->example()->associate($related);


<a name="configuration"></a>
## Configuration

**Example Definition:**

    protected $fields = [
        'example' => [
            'type'   => 'anomaly.field_type.relationship',
            'config' => [
                'column_type' => 'integer',
                'related'     => 'Anomaly\UsersModule\User\UserModel',
                'handler'     => 'Anomaly\RelationshipFieldType\RelationshipFieldTypeOptions@handle',
            ]
        ]
    ];

### `column_type`

An alternative column type. The default value is `integer`.

### `related`

The class string of the related model.

### `handler`

The options handler callable string. Any valid callable class string can be used. The default value is `'Anomaly\RelationshipFieldType\RelationshipFieldTypeOptions@handle'`.

The handler is responsible for setting the available options on the field type instance.

**NOTE:** This option can not be set through the GUI configuration.


<a name="output"></a>
## Output

This field type returns the related entry instance.

    // Twig usage
    {{ entry.example.id }} or {{ entry.example.name }}
    
    // API usage
    $entry->example->id; or $entry->example->name;
