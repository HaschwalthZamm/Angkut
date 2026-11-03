<?php

namespace App\Exceptions;

use Exception;

class TeamNotInRegionException extends Exception
{
    public function __construct(string $message = 'Tim tidak beroperasi di wilayah laporan ini.')
    {
        parent::__construct($message);
    }
}
