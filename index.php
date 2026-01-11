<?php
session_start();
error_reporting(E_ALL);


require_once 'functions.php';


$host = 'localhost';
$db_name = 'query_store';
$user = 'root';
$pass = '';

$db = new PDO("mysql:host={$host};dbname={$db_name}", $user, $pass);


if (isset($_SESSION['tables'])) {
    create_tables();
}

check();











?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Query Store</h1>

    <!-- <a href="index.php?action=drop" onclick="return confirm('Вы уверены?')">Удалить таблицы</a> -->

</body>

</html>










































