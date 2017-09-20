## Introduction[](#introduction)

`anomaly.field_type.relationship`

The relationship field type provides a select / lookup relation input.


### Configuration[](#introduction/configuration)

Below is a list of available configuration with default values:

    "example" => [
        "type"   => "anomaly.field_type.relationship",
        "config" => [
            "related"        => null,
            "mode"           => "lookup",
            "key_name"       => null,
            "title_name"     => null,
            "value_table"    => null,
            "selected_table" => null,
            "lookup_table"   => null,
            "handler"        => "\Anomaly\RelationshipFieldType\Handler\Related@handle",
        ]
    ]

###### Configuration

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Example</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

related

</td>

<td>

`\Anomaly\UsersModule\User\UserModel`

</td>

<td>

The related model.

</td>

</tr>

<tr>

<td>

mode

</td>

<td>

dropdown

</td>

<td>

The input mode. Valid options are `lookup`, `search`, and `dropdown`.

</td>

</tr>

<tr>

<td>

key_name

</td>

<td>

slug

</td>

<td>

The name of the key field. Default is `id`. Only applies to `dropdown` mode.

</td>

</tr>

<tr>

<td>

title_name

</td>

<td>

name

</td>

<td>

The name of the title field. Default is the `title_column`. Only applies to `dropdown` mode.

</td>

</tr>

<tr>

<td>

value_table

</td>

<td>

`\App\Example\MyValueTable`

</td>

<td>

The builder for the value table.

</td>

</tr>

<tr>

<td>

selected_table

</td>

<td>

`\App\Example\MySelectedTable`

</td>

<td>

The builder for the selections table.

</td>

</tr>

<tr>

<td>

lookup_table

</td>

<td>

`\App\Example\MyLookupTable`

</td>

<td>

The builder for the lookup table.

</td>

</tr>

<tr>

<td>

handler

</td>

<td>

`\App\Example\MyOptions@handle`

</td>

<td>

The option handler.

</td>

</tr>

</tbody>

</table>


#### Option Handlers[](#introduction/configuration/option-handlers)

Option handlers are responsible for setting the available options on the field type. You can define your own option handler to add your own logic to available options.

You can define custom handlers as a callable string where `@handle` will be assumed if no method is provided:

    "handler" => \App\Example\MyOptions::class // Assumes @handle

Option handlers can also a handler with a closure:

    "example" => [
        "config" => [
            "handler" => function (MultipleFieldType $fieldType, ExampleRepositoryInterface $entries) {
                $fieldType->setOptions($entries->getCustomEntries()->pluck('title', 'id')->all());
            }
        ]
    ]

<div class="alert alert-info">**Remember:** Closures can not be stored in the database so your closure type handlers must be set / overridden from the form builder.</div>


##### Writing Option Handlers[](#introduction/configuration/option-handlers/writing-option-handlers)

Writing custom option handlers is easy. To begin create a class with the method you defined in the config option.

    "handler" => "App/Example/MyOptions@handle"

The handler string is called via Laravel's service container. The `RelationshipFieldType $fieldType` is passed as an argument.

<div class="alert alert-primary">**Pro Tip:** Handlers are called through Laravel's service container so method and class injection is supported.</div>

    <?php namespace App/Example;

    class MyOptions
    {
        public function handle(MultipleFieldType $fieldType, ExampleRepositoryInterface $entries) {
            $fieldType->setOptions(
                $entries->getCustomEntries()->pluck('title', 'id')->all()
            );
        }
    }


### Hooks[](#introduction/hooks)

This section will introduce you to the hooks registered by this addon and how to use them.


#### EntryModel::newRelationshipFieldTypeLookupTableBuilder()[](#introduction/hooks/entrymodel-newrelationshipfieldtypelookuptablebuilder)

The `new_relationship_field_type_lookup_table_builder` hook binding returns an instance of the lookup table builder.

This hook let's you override the table builder for the lookup UI.

###### Returns: `\Anomaly\RelationshipFieldType\Table\LookupTableBuilder`

###### Example

    public function newRelationshipFieldTypeLookupTableBuilder() {
        return app(\App\Example\MyLookupTable::class);
    }

##### Automatically detected lookup tables

Lookup tables that are picked up automatically do not require you defining the hook method on your related model.

The lookup table builder location format is:

    \Your\Related\Model\Namespace}\Support\RelationshipFieldType\LookupTableBuilder;

Consider the example in the Pages module:

    \Anomaly\PagesModule\Page\PageModel
    \Anomaly\PagesModule\Page\Support\RelationshipFieldType\LookupTableBuilder


##### Writing Lookup Table Builders[](#introduction/hooks/entrymodel-newrelationshipfieldtypelookuptablebuilder/writing-lookup-table-builders)

Writing custom option handlers is easy. Simply create your class and extend the base lookup table builder:

    <?php namespace App\Example;

    class LookupTableBuilder extends \Anomaly\RelationshipFieldType\Table\LookupTableBuilder
    {

        protected $filters = [
            'title',
        ];

        protected $columns = [
            'title',
            'path',
        ];
    }

If you are not relying on automatic detection then all you need to do next is define the hook method on your related model:

    public function newRelationshipFieldTypeLookupTableBuilder() {
        return app(\App\Example\LookupTableBuilder::class);
    }


#### EntryModel::newRelationshipFieldTypeValueTableBuilder()[](#introduction/hooks/entrymodel-newrelationshipfieldtypevaluetablebuilder)

The `new_relationship_field_type_value_table_builder` hook binding returns an instance of the value table builder.

This hook let's you override the table builder for the value UI.

###### Returns: `\Anomaly\RelationshipFieldType\Table\ValueTableBuilder`

###### Example

    public function newRelationshipFieldTypeValueTableBuilder() {
        return app(\App\Example\MyValueTable::class);
    }

##### Automatically detected value tables

Value tables that are picked up automatically do not require you defining the hook method on your related model.

The value table builder location format is:

    {\Your\Related\Model\Namespace}\Support\RelationshipFieldType\ValueTableBuilder;

Consider the example in the Pages module:

    \Anomaly\PagesModule\Page\PageModel
    \Anomaly\PagesModule\Page\Support\RelationshipFieldType\ValueTableBuilder


##### Writing Value Tables Builders[](#introduction/hooks/entrymodel-newrelationshipfieldtypevaluetablebuilder/writing-value-tables-builders)

Writing custom value tables is easy. Simply create your class and extend the base value table builder:

    <?php namespace App\Example;

    class ValueTableBuilder extends \Anomaly\RelationshipFieldType\Table\ValueTableBuilder
    {

        protected $filters = [
            'title',
        ];

        protected $columns = [
            'title',
            'path',
        ];
    }

If you are not relying on automatic detection then all you need to do next is define the hook method on your related model:

    public function newRelationshipFieldTypeValueTableBuilder() {
        return app(\App\Example\ValueTableBuilder::class);
    }


#### EntryModel::newRelationshipFieldTypeSelectedTableBuilder()[](#introduction/hooks/entrymodel-newrelationshifieldtypeselectedtablebuilder)

The `new_relationship_field_type_selected_table_builder` hook binding returns an instance of the selected table builder.

This hook let's you override the table builder for the selected options UI.

###### Returns: `\Anomaly\MultipleFieldType\Table\SelectedTableBuilder`

###### Example

    public function newRelationshipFieldTypeSelectedTableBuilder() {
        return app(\App\Example\MySelectedTable::class);
    }

##### Automatically detected selected tables

Selected tables that are picked up automatically do not require you defining the hook method on your related model.

The selected table builder location format is:

    {\Your\Related\Model\Namespace}\Support\RelationshipFieldType\SelectedTableBuilder;

Consider the example in the Pages module:

    \Anomaly\PagesModule\Page\PageModel
    \Anomaly\PagesModule\Page\Support\RelationshipFieldType\SelectedTableBuilder


##### Writing Selected Tables Builders[](#introduction/hooks/entrymodel-newrelationshifieldtypeselectedtablebuilder/writing-selected-tables-builders)

Writing custom selected tables is easy. Simply create your class and extend the base selected table builder:

    <?php namespace App\Example;

    class SelectedTableBuilder extends \Anomaly\RelationshipFieldType\Table\SelectedTableBuilder
    {

        protected $filters = [
            'title',
        ];

        protected $columns = [
            'title',
            'path',
        ];
    }

If you are not relying on automatic detection then all you need to do next is define the hook method on your related model:

    public function newRelationshipFieldTypeSelectedTableBuilder() {
        return app(\App\Example\SelectedTableBuilder::class);
    }
