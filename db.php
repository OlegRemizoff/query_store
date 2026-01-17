<?php

// Подключение к БД
$config = parse_ini_file('.env');

$db_host = $config['DB_HOST'] ?? 'localhost';
$db_name   = $config['DB_DATABASE'] ?? 'query_store';
$db_user = $config['DB_USERNAME'] ?? 'root';
$db_pass = $config['DB_PASSWORD'] ?? '';

$db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass);


return $db;