<p align="center">
<img src="https://app.codeship.com/projects/d56db760-3f91-0138-8fe9-7ef95a7c016e/status?branch=master" alt="Build Status">
<img src='https://coveralls.io/repos/github/ChrGriffin/collection-macro-csv/badge.svg?branch=master' alt='Coverage Status' />
</p>

# Laravel Collection Macros: CSV

This package will add two Collection macros to transform your Collection into a CSV-ready array or a CSV string, respectively.

## Installation

Install in your Laravel project via composer:

```shell script
composer install chrgriffin/collection-macro-csv
```

If your version of Laravel supports auto-discovery (versions 5.5 and up), that's it!

For older versions of Laravel, you will need to edit your `config/app.php` file to include the service provider in your providers array:

```php
return [
    // ...
    'providers' => [
        // ...
        CollectionMacroCsv\ServiceProvider::class
    ]
];
```

## Usage

You should now be able to chain `->toCsvArray()` and `->toCsvString` on any Collection.

### toCsvArray

`->toCsvArray` will transform a two dimensional Collection of associative arrays into a two dimensional array of 'rows' ready for CSV formatting.

```php
$associativeArray = [
    [
        'name' => 'Geralt of Rivia',
        'occupation' => 'Witcher'
    ],
    [
        'name' => 'Yennefer of Vengerberg',
        'occupation' => 'Sorceress'
    ]
];

$csvArray = collect($associativeArray)->toCsvArray();

/*
 * [
 *     ['name', 'occupation'],
 *     ['Geralt of Rivia', 'Witcher'],
 *     ['Yennefer of Vengerberg', 'Sorceress']
 * ]
 */
```

### toCsvString

`->toCsvString()` will transform a two dimensional Collection of arrays into a CSV string.

```php
$associativeArray = [
    [
        'name' => 'Geralt of Rivia',
        'occupation' => 'Witcher'
    ],
    [
        'name' => 'Yennefer of Vengerberg',
        'occupation' => 'Sorceress'
    ]
];

$csvString = collect($associativeArray)->toCsvString();

// name,occupation\nGeralt of Rivia,Witcher\nYennefer of Vengerberg,Sorceress
```

You can also pass in a custom delimiter if you need to use something other than a comma:

```php
$csvString = collect($associativeArray)->toCsvString('|');

// name|occupation\nGeralt of Rivia|Witcher\nYennefer of Vengerberg|Sorceress

```

### Inconsistent Columns

For Collections of arrays where the array indexes are not consistent with one another, a default value of `null` will be used to 'fill in' missing values:

```php
$associativeArray = [
    [
        'name' => 'Geralt of Rivia',
        'occupation' => 'Witcher',
        'witcher_school' => 'Wolf'
    ],
    [
        'name' => 'Yennefer of Vengerberg',
        'occupation' => 'Sorceress',
        'magic_speciality' => 'Portals'
    ]
];

$csvArray = collect($associativeArray)->toCsvArray();

/*
 * [
 *     ['name', 'occupation', 'witcher_school', 'magic_speciality'],
 *     ['Geralt of Rivia', 'Witcher', 'Wolf', null],
 *     ['Yennefer of Vengerberg', 'Sorceress', null, 'Portals']
 * ]
 */

$csvString = collect($associativeArray)->toCsvString();

// name,occupation,witcher_school,magic_speciality\nGeralt of Rivia,Witcher,Wolf,\nYennefer of Vengerberg,Sorceress,,Portals
```

### Structure Requirements

The only requirement is that your Collection contain only arrays. If a non-array value is encountered at the first level of the Collection, a `MalformedCollectionException` will be thrown.

```php
$malformedArray = [
    [
        'name' => 'Geralt of Rivia',
        'occupation' => 'Witcher',
        'witcher_school' => 'Wolf'
    ],
    'Yennefer of Vengerberg'
];

// throws a MalformedCollectionException
$csvArray = collect($malformedArray)->toCsvArray();
```
