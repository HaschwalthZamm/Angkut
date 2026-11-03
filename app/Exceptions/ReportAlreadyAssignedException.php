<?php

namespace App\Exceptions;

use Exception;

class ReportAlreadyAssignedException extends Exception
{
    public function __construct(string $message = 'Laporan sudah ditugaskan ke tim.')
    {
        parent::__construct($message);
    }
}
