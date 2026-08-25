<?php
$service_slug = preg_replace('/[^a-z0-9-]/', '', $_GET['service'] ?? '');
require __DIR__ . '/service-template.php';
