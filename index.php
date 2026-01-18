<?php
session_start();
error_reporting(E_ALL);


require_once 'functions.php';
$db = require_once "db.php";


define("PAGES", __DIR__ . "/pages");
define("TEMPLATES", __DIR__ . "/templates");


// Роутер
$route = $_GET['route'] ?? 'home';

$routes = [
    'home'    => 'home.php',
    'register'   => 'register.php',
    'user' => 'user.php',
    'logout'   => 'logout.php'
];


// Проверяет есть ли нужные таблицы
// и заполняет их дынными
check();





?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <title>Query Store</title>
</head>
</head>

<body>

    <div class="container">
        <!-- Navbar -->
        <?php include_once "templates/navbar.html" ?>
        <!-- End navbar -->
        <!-- Alerts -->
        <?php include_once "templates/alert.html" ?>
        <!-- End alerts -->


        <?php
        if (array_key_exists($route, $routes)) {
            include PAGES . DIRECTORY_SEPARATOR . $routes[$route];
        } else {
            include TEMPLATES . DIRECTORY_SEPARATOR . '404.html';
        }
        ?>



    </div>






    
    <script src="#"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>