<?php
require_once __DIR__ . '/../controller/08TemperatureController.php';

$controller = new TemperatureController();
$controller->handleAjaxRequest();
