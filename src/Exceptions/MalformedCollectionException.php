<?php

namespace CollectionMacroCsv\Exceptions;

use InvalidArgumentException;
use Throwable;

class MalformedCollectionException extends InvalidArgumentException
{
    public function __construct($message = null, $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message ?? 'Provided Collection must be a Collection of arrays',
            $code,
            $previous
        );
    }
}
