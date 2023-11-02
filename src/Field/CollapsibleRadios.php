<?php

namespace Creode\CollapsibleRadios\Field;

use Creode\CollapsibleRadios\RadioHelper;
use Laravel\Nova\Fields\Field;

class CollapsibleRadios extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'collapsible-radios';

    /**
     * The field's options Array.
     *
     * @var array
     */
    public $optionsArray;

    /**
     * Set the options for the select menu.
     *
     * @param array $options
     *
     * @return self
     */
    public function options($options)
    {
        $radioHelper = app(RadioHelper::class);
        $structuredOptions = $radioHelper::createMultidimensionalStructure($options);

        $this->optionsArray = $structuredOptions;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        $this->withMeta([
            'options' => $this->serializeOptions(),
        ]);

        return parent::jsonSerialize();
    }

    /**
     * Serialize options for the field.
     *
     * @param  bool  $searchable
     * @return array<int, array<string, mixed>>
     *
     * @phpstan-return array<int, array{group: string, label: string, value: TOptionValue}>
     */
    protected function serializeOptions()
    {
        /** @var TOption $options */
        return value($this->optionsArray);
    }
}
