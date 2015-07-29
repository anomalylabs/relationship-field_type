# Output

This field type returns the related entry instance.

```
// Twig usage
{{ entry.example.id }} or {{ entry.example.name }}

// API usage
$entry->example->id; or $entry->example->name;
```

This field type can be access on related instances too.

```
// Twig usage
{{ entry.parent.grand_parent.name }}

// API usage
$entry->parent->grand_parent->name;
```
