<?php

namespace App\ExampleExceptions;

use Exception;

class ExampleException extends Exception {


    public function __construct($code = 400)
    {
        \Log::info("ExampleExceptions");
    }


}