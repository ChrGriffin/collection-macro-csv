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
        $keys = $this->collection
            ->flatMap(function (array $row) {
                return array_keys($row);
            })
            ->unique()
            ->values();

        return array_merge(
            [$keys->toArray()],
            $this->collection
                ->map(function (array $row) use ($keys) {
                    $array = [];
                    foreach($keys as $key) {
                        $array[$key] = $row[$key] ?? null;
                    }
                    return array_values($array);
                })
                ->values()
                ->toArray()
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
