<?php
$header = require_once hl_path("@/config/i18n/header.php");


$translation = [
    'hello_world' => 'Привет, Мир!',
    'unique_visits' => 'Зафиксировано {%count%} уникальных посещений',
    // ...
];

$merged = array_merge($header, $translation);

return $merged;
