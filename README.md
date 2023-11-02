# Collapsible Radios - Laravel Nova

Contains a new Laravel Nova field for building collapsible radios for parent and child relationships.

![Field in use](https://github.com/creode-modules/nova-collapsible-radios/blob/1.x/docs/images/folder-example.png?raw=true, 'Image of hierarchy showing the field in use.')

## Installation

You can install the package via composer:

```bash
composer require creode/collapsible-radios
```

## Usage
To create an instance of a new field just use the `CollapsibleRadios` class in your Nova resource's `fields` method. You need to ensure that your options provide the following fields:

 - `label` - The label to display for the option
 - `value` - The value to use for the option
 - `id` - The ID of the option
 - `parent_id` - The ID of the parent option

These fields are used to build the collapsible radios based on parent_ids.

Here is a basic example for how we would accept input for options.
```php
use Creode\CollapseRadios\Field\CollapsibleRadios;

CollapsibleRadios::make('Model', 'model_id')
    ->options([
        [
            'label' => 'Option 1',
            'value' => 1,
            'id' => 1,
            'parent_id' => null,
        ],
        [
            'label' => 'Option 2',
            'value' => 2,
            'id' => 2,
            'parent_id' => 1,
        ],
                [
            'label' => 'Option 3',
            'value' => 3,
            'id' => 3,
            'parent_id' => 2,
        ]
    ])
    ->nullable()
    ->rules('required')
```

This would generate a structure like the following:

- Option 1
    - Option 2
        - Option 3

or if you want to easily map model data to it:
```php
use Creode\CollapseRadios\Field\CollapsibleRadios;

CollapsibleRadios::make('Model', 'model_id')
    ->options(
        Model::all()->map(
            function ($model) {
                return [
                    'label' => $model->name,
                    'value' => $model->id,
                    'id' => $model->id,
                    'parent_id' => $model->parent_id ?: null,
                ];
            }
        )
    )
    ->nullable()
    ->rules('required')
```

## Roadmap

We plan to implement the following features as our requirements develop for this project:

 - [ ] Allow for a default option to be selected
 - [ ] Allow for multiple options to be selected

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Creode](https://github.com/creode)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
