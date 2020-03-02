<?php

namespace CollectionMacroCsv;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        if(!Collection::hasMacro('toCsvArray')) {
            Collection::macro('toCsvArray', function () {
                return (new CsvTransformer($this))->toArray();
            });
        }

        if(!Collection::hasMacro('toCsvString')) {
            Collection::macro('toCsvString', function ($delimiter = ',') {
                return (new CsvTransformer($this))->setDelimiter($delimiter)->toString();
            });
        }
    }
}
