<?php

namespace App\Validator;

abstract class BaseValidator
{
    abstract public function validate(...$args): bool;
}
