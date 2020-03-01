<?php

namespace CollectionMacroCsv\Tests\Unit;

use CollectionMacroCsv\CsvTransformer;
use CollectionMacroCsv\Tests\TestCase;

class CsvTransformerTest extends TestCase
{
    private $simpleArray = [
        [
            'id' => 1,
            'name' => 'Geralt of Rivia',
            'occupation' => 'Witcher'
        ],
        [
            'id' => 2,
            'name' => 'Yennefer of Vengerberg',
            'occupation' => 'Sorceress'
        ]
    ];

    public function testItCanBeInstantiatedWithACollection(): void
    {
        $this->assertInstanceOf(CsvTransformer::class, new CsvTransformer(collect()));
    }

    public function testItTransformsASimpleAssociativeArrayIntoACsvArray(): void
    {
        $transformer = new CsvTransformer(collect($this->simpleArray));

        $this->assertEquals(
            [
                ['id', 'name', 'occupation'],
                [1, 'Geralt of Rivia', 'Witcher'],
                [2, 'Yennefer of Vengerberg', 'Sorceress']
            ],
            $transformer->toArray()
        );
    }

    public function testItTransformsASimpleAssociativeArrayIntoACsvString(): void
    {
        $transformer = new CsvTransformer(collect($this->simpleArray));

        $this->assertEquals(
            "id,name,occupation\n1,Geralt of Rivia,Witcher\n2,Yennefer of Vengerberg,Sorceress",
            $transformer->toString()
        );
    }
}
