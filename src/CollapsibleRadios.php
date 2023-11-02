<?php

namespace Creode\CollapsibleRadios;

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
        $this->optionsCallback = $options;

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed>
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
