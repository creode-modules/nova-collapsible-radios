<?php

namespace Creode\CollapsibleRadios;

use Laravel\Nova\Fields\Select;

class CollapsibleRadios extends Select
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'collapsible-radios';

    /**
     * Serialize options for the field.
     *
     * @param  bool  $searchable
     * @return array<int, array<string, mixed>>
     *
     * @phpstan-return array<int, array{group: string, label: string, value: TOptionValue}>
     */
    protected function serializeOptions($searchable)
    {
        /** @var TOption $options */
        $options = value($this->optionsCallback);

        if (is_callable($options)) {
            $options = $options();
        }

        return $options;

        // return collect($options ?? [])->map(function ($label, $value) use ($searchable) {
        //     $label = $label instanceof Stringable ? (string) $label : $label;
        //     $value = Util::safeInt($value);

        //     if ($searchable && isset($label['group'])) {
        //         return [
        //             'label' => $label['group'].' - '.$label['label'],
        //             'value' => $value,
        //         ];
        //     }

        //     return is_array($label) ? $label + ['value' => $value] : ['label' => $label, 'value' => $value];
        // })->values()->all();
    }
}
