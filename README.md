# Collapsible Radios - Laravel Nova

Contains a new Laravel Nova field for building collapsible radios for parent and child relationships.

![Field in use](https://github.com/creode-modules/nova-collapsible-radios/blob/main/docs/images/folder-example.png?raw=true, 'Image of hierarchy showing the field in use.')

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
