<?php

namespace CollectionMacroCsv\Tests\Unit;

use CollectionMacroCsv\CsvTransformer;
use CollectionMacroCsv\Exceptions\MalformedCollectionException;
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

    private $mismatchedArray = [
        [
            'id' => 1,
            'name' => 'Geralt of Rivia',
            'occupation' => 'Witcher',
            'witcher_school' => 'Wolf'
        ],
        [
            'id' => 2,
            'name' => 'Yennefer of Vengerberg',
            'occupation' => 'Sorceress',
            'magic_speciality' => 'Portals'
        ]
    ];

    private $malformedArray = [
        [
            'id' => 1,
            'name' => 'Geralt of Rivia',
            'occupation' => 'Witcher'
        ],
        'Yennefer of Vengerberg'
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

    public function testItTransformsAMismatchedAssociativeArrayIntoACsvArrayWithAllColumns(): void
    {
        $transformer = new CsvTransformer(collect($this->mismatchedArray));

        $this->assertEquals(
            [
                ['id', 'name', 'occupation', 'witcher_school', 'magic_speciality'],
                [1, 'Geralt of Rivia', 'Witcher', 'Wolf', null],
                [2, 'Yennefer of Vengerberg', 'Sorceress', null, 'Portals']
            ],
            $transformer->toArray()
        );
    }

    public function testItTransformsAMismatchedAssociativeArrayIntoACsvStringWithAllColumns(): void
    {
        $transformer = new CsvTransformer(collect($this->mismatchedArray));

        $this->assertEquals(
            "id,name,occupation,witcher_school,magic_speciality\n1,Geralt of Rivia,Witcher,Wolf,\n2,Yennefer of Vengerberg,Sorceress,,Portals",
            $transformer->toString()
        );
    }

    public function testItThrowsAnExceptionIfTheCollectionIsMalformed(): void
    {
        $this->expectException(MalformedCollectionException::class);
        new CsvTransformer(collect($this->malformedArray));
    }

    public function testItUsesAGivenDelimiterInsteadOfAComma(): void
    {
        $transformer = (new CsvTransformer(collect($this->simpleArray)))
            ->setDelimiter(';');

        $this->assertEquals(
            "id;name;occupation\n1;Geralt of Rivia;Witcher\n2;Yennefer of Vengerberg;Sorceress",
            $transformer->toString()
        );
    }
}
