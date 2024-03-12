<?php

namespace App\Models;

class ApiError
{
    public function __construct(public string $message = "Api error received", public array $errors = [])
    {

    }
}