<?php
require_once __DIR__ . '/../controller/TemperatureController.php';

$controller = new TemperatureController();
$controller->handleAjaxRequest();
