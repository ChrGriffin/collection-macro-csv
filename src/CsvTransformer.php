<?php

namespace CollectionMacroCsv;

use Illuminate\Support\Collection;

class CsvTransformer
{
    /** @var Collection */
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function toArray(): array
    {
        return array_merge(
            [array_keys($this->collection->first())],
            $this->collection->map(function (array $item) {
                return array_values($item);
            })->toArray()
        );
    }

    public function toString(): string
    {
        return collect($this->toArray())
            ->map(function (array $row) {
                return implode(',', $row);
            })
            ->join("\n");
    }
}
