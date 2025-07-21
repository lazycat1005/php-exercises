<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\TemperatureController;

$controller = new TemperatureController();
$controller->handleAjaxRequest();
