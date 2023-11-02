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
     * The field's options callback.
     *
     * @var array<string|int, array<string, mixed>|string>|\Closure|callable|\Illuminate\Support\Collection|null
     *
     * @phpstan-var TOption|(callable(): (TOption))|(\Closure(): (TOption))|null
     */
    public $optionsCallback;

    /**
     * Set the options for the select menu.
     *
     * @param  array<string|int, array<string, mixed>|string>|\Closure|callable|\Illuminate\Support\Collection  $options
     * @return $this
     *
     * @phpstan-param TOption|(callable(): (TOption))|(\Closure(): (TOption)) $options
     */
    public function options($options)
    {
        $radioHelper = app(RadioHelper::class);
        $structuredOptions = $radioHelper::createMultidimensionalStructure($options);

        $this->optionsCallback = $structuredOptions;

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
        $options = value($this->optionsCallback);

        if (is_callable($options)) {
            $options = $options();
        }

        return $options;
    }
}
