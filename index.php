<?php
session_start();
error_reporting(E_ALL);


require_once 'functions.php';


$host = 'localhost';
$db_name = 'query_store';
$user = 'root';
$pass = '';

$db = new PDO("mysql:host={$host};dbname={$db_name}", $user, $pass);


// Проверяет есть ли нужные таблицы и заполняет их дынными
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
    <?php if (!empty($_SESSION['errors'])): ?>
    <?php 
        echo $_SESSION['errors'];
        unset($_SESSION['errors']); 
    ?>
    <?php endif; ?>

    <!-- <a href="index.php?action=drop" onclick="return confirm('Вы уверены?')">Удалить таблицы</a> -->

</body>

</html>










































