## Usage[](#usage)

This section will show you how to use the field type via API and in the view layer.


### Setting Values[](#usage/setting-values)

You can set the field type value with a model instance:

    $entry->example = $entry;

You can also set the value with an entry ID:

    $entry->example = 8;


### Basic Output[](#usage/basic-output)

This field type always returns an `\Anomaly\Streams\Platform\Entry\Contract\EntryInterface` instance.

###### Example

      $entry->example->getId();


### Presenter Output[](#usage/presenter-output)

When accessing the value from a decorated entry model the related entry will automatically be decorated with an instance of `\Anomaly\Streams\Platform\Entry\EntryPresenter`.

###### Example

    $decorated->example->id;

###### Twig

    {{ decorated.example.id }}
