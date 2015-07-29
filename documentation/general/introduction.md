# Relationship Field Type

*anomaly.field_type.relationship*

### A related entry dropdown field type.

The relationship field type provides an HTML select input with options from a related Stream or model.

### Usage

Simply set the related entry in order to associate it.

```
$entry->example = $related;
```

You may also use the relation method that is automatically compiled on the model.

```
$entry->example()->associate($related);
```
