<?php

namespace Creode\CollapsibleRadios;

class RadioHelper
{
    /**
     * Create a multidimensional structure from a flat collection.
     *
     * @param array $items    The flat collection.
     * @param ?int  $parentId The parent ID.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function createMultidimensionalStructure($items, $parentId = null)
    {
        $branch = collect();

        foreach ($items as $item) {
            // Convert to an object to make it easier to access.
            $item = (object) $item;

            if ($item->parent_id == $parentId) {
                $children = self::createMultidimensionalStructure($items, $item->id);
                if ($children) {
                    $item->children = $children;
                }
                $branch->push($item);
            }
        }

        return $branch;
    }
}
