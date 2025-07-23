<?php

namespace App\Controller;

abstract class BaseController
{
    abstract public function handleRequest(): void;
}
