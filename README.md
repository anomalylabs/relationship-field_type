# Relationship Field Type

*anomaly.field_type.relationship*

#### An entry relation field type.

The relationship field type provides an HTML select input with options from a related Stream or model.

## Configuration

- `handler` - the class string of the options handler
- `related` - the class string of the related model
- `title` - the related column to use as the option title 

The handler will default to a class packaged with the field type. The title option will default to the model's title column.  

#### Example

	config => [
	    'related' => 'Anomaly\UsersModule\User\UserModel',
	    'title' => 'username'
	]
