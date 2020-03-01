<?php

namespace CollectionMacroCsv\Tests\Fakes;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class FakeOverridingServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        Collection::macro('toCsvArray', function () {
            return 'this should override the csv macro';
        });

        Collection::macro('toCsvString', function () {
            return 'this should override the csv macro';
        });
    }
}
