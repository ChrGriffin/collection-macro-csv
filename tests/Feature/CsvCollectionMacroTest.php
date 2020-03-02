<?php

namespace CollectionMacroCsv\Tests\Feature;

use CollectionMacroCsv\ServiceProvider;
use CollectionMacroCsv\Tests\TestCase;

class CsvCollectionMacroTest extends TestCase
{
    private $array = [
        ['name' => 'Geralt of Rivia', 'occupation' => 'Witcher'],
    ];

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function testTheArrayMacroIsAddedToLaravelCollections(): void
    {
        $this->assertIsArray(collect($this->array)->toCsvArray());
    }

    public function testTheStringMacroIsAddedToLaravelCollections(): void
    {
        $this->assertIsString(collect($this->array)->toCsvString());
    }

    public function testItUsesThePassedDelimiterInsteadOfAComma(): void
    {
        $this->assertEquals("name;occupation\nGeralt of Rivia;Witcher", collect($this->array)->toCsvString(';'));
    }
}
