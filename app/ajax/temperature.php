<?php
require_once '../vendor/autoload.php';

use App\Controller\TemperatureController;

$controller = new TemperatureController();
$controller->handleAjaxRequest();
