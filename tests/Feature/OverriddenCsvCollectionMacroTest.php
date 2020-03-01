<?php

namespace CollectionMacroCsv\Tests\Feature;

use CollectionMacroCsv\ServiceProvider;
use CollectionMacroCsv\Tests\Fakes\FakeOverridingServiceProvider;
use CollectionMacroCsv\Tests\TestCase;

class OverriddenCsvCollectionMacroTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            FakeOverridingServiceProvider::class,
            ServiceProvider::class
        ];
    }

    public function testTheArrayMacroDoesNotOverrideAnExistingCollectionMacro(): void
    {
        $this->assertEquals('this should override the csv macro', collect()->toCsvArray());
    }

    public function testTheStringMacroDoesNotOverrideAnExistingCollectionMacro(): void
    {
        $this->assertEquals('this should override the csv macro', collect()->toCsvString());
    }
}
