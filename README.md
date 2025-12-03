# Relationship Field Type

*anomaly.field_type.relationship*

A powerful field type for creating relationships between stream entries or models in PyroCMS.

## Description

The relationship field type provides multiple input modes (dropdown, lookup, search) for selecting related entries from other streams or Eloquent models. It creates a `belongsTo` relationship and handles foreign key management automatically.

## Features

- **Multiple Input Modes**: Dropdown, lookup modal, or AJAX search
- **Stream or Model Relations**: Link to any stream or Eloquent model
- **Pre-defined Handlers**: Built-in handlers for common relationships (users, fields, assignments)
- **Custom Queries**: Filter and customize available options
- **Caching**: Intelligent caching for performance
- **Value Tables**: Interactive table view for managing relationships
- **Lazy Loading**: Efficient loading of related data
- **Translations**: Full multilingual support

## Installation

This field type is included with the Streams Platform.

```bash
composer require anomaly/relationship-field_type
```

## Configuration

### Basic Configuration

```php
'category' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => \App\Category\CategoryModel::class,
        'mode'    => 'dropdown', // dropdown, lookup, or search
    ],
],
```

### Configuration Options

#### `related` (required)
The related stream or model class.

```php
// Stream notation
'related' => 'example.module.posts'

// Full model class
'related' => \Anomaly\PostsModule\Post\PostModel::class

// Pre-defined handlers
'related' => 'users'      // User model
'related' => 'fields'     // Field model
'related' => 'related'    // Related entries handler
'related' => 'assignments' // Assignment model
```

#### `mode` (default: 'dropdown')
The input interface mode.

```php
'mode' => 'dropdown' // Standard select dropdown
'mode' => 'lookup'   // Modal lookup table
'mode' => 'search'   // AJAX search input
```

#### `title_name`
Custom title attribute for display.

```php
'title_name' => 'full_name' // Use 'full_name' instead of default 'title'
```

#### `handler`
Custom options handler.

```php
'handler' => 'App\Example\CustomOptionsHandler@handle'
```

#### `query`
Customize the query for available options.

```php
'query' => function ($query) {
    return $query->where('published', true)->orderBy('title');
}
```

#### `value_table`
Custom table builder for the value display.

```php
'value_table' => \App\Example\CustomValueTableBuilder::class
```

## Input Modes

### Dropdown Mode
Standard HTML select dropdown. Best for small sets of options (< 100).

```php
'author' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => 'users',
        'mode'    => 'dropdown',
    ],
],
```

### Lookup Mode
Modal window with searchable table. Best for medium to large datasets.

```php
'product' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => \App\Product\ProductModel::class,
        'mode'    => 'lookup',
    ],
],
```

### Search Mode
AJAX-powered search input. Best for very large datasets.

```php
'customer' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => \App\Customer\CustomerModel::class,
        'mode'    => 'search',
    ],
],
```

## Usage Examples

### Basic Stream Relationship

```php
protected $fields = [
    'category' => [
        'type'   => 'anomaly.field_type.relationship',
        'config' => [
            'related' => 'example.module.categories',
        ],
    ],
];
```

### User Relationship with Pre-defined Handler

```php
'created_by' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => 'users',
        'mode'    => 'search',
    ],
],
```

### Custom Query Filtering

```php
'parent_page' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => \Anomaly\PagesModule\Page\PageModel::class,
        'query'   => function ($query) {
            return $query->where('type', 'parent')->published();
        },
    ],
],
```

### Custom Options Handler

```php
'category' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => \App\Category\CategoryModel::class,
        'handler' => 'App\Category\CategoryOptionsHandler@handle',
    ],
],
```

Handler example:

```php
namespace App\Category;

class CategoryOptionsHandler
{
    public function handle(RelationshipFieldType $fieldType)
    {
        $options = [];
        
        $categories = CategoryModel::where('active', true)
            ->orderBy('sort_order')
            ->get();
            
        foreach ($categories as $category) {
            $options[$category->id] = $category->name;
        }
        
        $fieldType->setOptions($options);
    }
}
```

## Accessing Values

### Basic Output

```php
// Get the related entry
$category = $entry->category;

// Access related entry properties
echo $entry->category->name;
echo $entry->category->slug;
```

### In Templates

```twig
{# Access related entry #}
{{ entry.category.name }}
{{ entry.category.description }}

{# Check if relationship exists #}
{% if entry.category %}
    <a href="{{ entry.category.url }}">
        {{ entry.category.title }}
    </a>
{% endif %}
```

### Presenter Output

```php
// Get the related entry via presenter
$category = $entry->present()->category;

// Access presenter methods
echo $entry->present()->category->title;
echo $entry->present()->category->link();
```

## Setting Values

### By ID

```php
$entry->category_id = 5;
$entry->save();
```

### By Model Instance

```php
$category = CategoryModel::find(5);
$entry->category()->associate($category);
$entry->save();
```

### Via Relationship

```php
$entry->category()->associate($categoryModel);
$entry->save();

// Or
$entry->category()->dissociate();
$entry->save();
```

## Database Structure

The field type creates an integer foreign key column:

```php
// If your field is named 'category'
// Column created: category_id (integer)

Schema::table('your_table', function (Blueprint $table) {
    $table->integer('category_id')->nullable();
});
```

### Custom Column Type

```php
'category' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related'     => 'categories',
        'column_type' => 'bigInteger', // For large IDs
    ],
],
```

## Pre-defined Handlers

### Users Handler
Quick access to user relationships.

```php
'author' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => 'users',
    ],
],
```

### Fields Handler
Relate to field definitions.

```php
'field' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => 'fields',
    ],
],
```

### Assignments Handler
Relate to stream field assignments.

```php
'assignment' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => 'assignments',
    ],
],
```

### Related Handler
Dynamic related entries based on context.

```php
'related_entry' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => 'related',
    ],
],
```

## Advanced Usage

### Eager Loading

```php
// Eager load relationships
$entries = EntryModel::with('category')->get();

foreach ($entries as $entry) {
    echo $entry->category->name; // No additional query
}
```

### Custom Title Display

```php
'user' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related'    => 'users',
        'title_name' => 'display_name', // Use display_name instead of title
    ],
],
```

### Nested Relationships

```php
// Access nested relationships
$entry->category->parent->name;
$entry->author->company->address->city;
```

### Query Scopes in Configuration

```php
'featured_product' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => \App\Product\ProductModel::class,
        'query'   => function ($query) {
            return $query->featured()
                ->inStock()
                ->where('price', '>', 0)
                ->orderBy('popularity', 'desc');
        },
    ],
],
```

## Best Practices

### Choose the Right Mode
- **Dropdown**: < 100 options, simple relationships
- **Lookup**: 100-10,000 options, need search/filter
- **Search**: > 10,000 options, large datasets

### Performance Optimization
- Use eager loading for multiple entries
- Enable caching for static relationships
- Add database indexes on foreign key columns
- Limit query results in configuration

### Validation

```php
'category' => [
    'type'  => 'anomaly.field_type.relationship',
    'rules' => [
        'required',
        'exists:categories,id',
    ],
    'config' => [
        'related' => 'categories',
    ],
],
```

## Common Use Cases

### Blog Post Categories
```php
'category' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => ['related' => 'blog.module.categories'],
],
```

### Product Manufacturers
```php
'manufacturer' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => \App\Manufacturer\ManufacturerModel::class,
        'mode'    => 'search',
    ],
],
```

### Content Authors
```php
'author' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => ['related' => 'users'],
],
```

### Parent/Child Hierarchies
```php
'parent' => [
    'type'   => 'anomaly.field_type.relationship',
    'config' => [
        'related' => self::class,
        'query'   => function ($query) {
            return $query->whereNull('parent_id');
        },
    ],
],
```

## Troubleshooting

### Options Not Loading
- Verify the related model/stream exists
- Check model accessibility and permissions
- Clear cache: `php artisan cache:clear`

### Slow Performance
- Use search mode for large datasets
- Enable query result caching
- Add database indexes
- Optimize eager loading

### Foreign Key Issues
- Ensure related table exists
- Verify column type matches ID type
- Check foreign key constraints

## API Methods

```php
// Get related model
$fieldType->getRelatedModel();

// Get relation
$fieldType->getRelation();

// Get options
$fieldType->getOptions();

// Get/Set value
$fieldType->getValue();
$fieldType->setValue($value);

// Get ID
$fieldType->id();
```

## Requirements

- PyroCMS 3.x
- Anomaly Streams Platform ^1.10

## Support

- **Email**: support@anomaly.is
- **Website**: http://pyrocms.com/
- **Documentation**: [PyroCMS Documentation](https://pyrocms.com/documentation)

## License

This field type is open-sourced software licensed under the [MIT license](LICENSE.md).

## Authors

- **PyroCMS, Inc.** - [Website](http://pyrocms.com/) - support@pyrocms.com
