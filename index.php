<?php
ob_start(); // Headers already sent
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
    'logout' => 'register.php'
    
];


// Регистрация
if (isset($_POST['register'])) {
    registration();
    header("Location: index.php?route=user");
    exit();
}


// Авторизация
if (isset($_POST['auth'])) {
    login();
    header("Location: index.php?route=user");
    exit();
}


// Logout
if ($route === 'logout') {
    logout();
    header("Location: index.php?route=home");
    exit();
}


// AJAX Добавление нового запроса
if (isset($_POST['addAjaxQuery'])) {
    $res = add_query_ajax();
    echo json_encode($res);
    die;
}


// Добавление нового запроса
if (isset($_POST['add'])) {
    add_query();
    header("Location: index.php?route=user");
    exit();
}


// Изменения запроса
if (isset($_POST['rewrite']) && isset($_POST['query_id']) && !empty($_POST['rewrite_sql'])) {
    $query_id = $_POST['query_id'];
    $new_query = $_POST['rewrite_sql'];

    update_query($query_id, $new_query);
    header("Location: index.php?route=user");
    exit();
}



// Проверяет есть ли нужные таблицы
// и заполняет их дынными
check();





?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
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



    


    
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="./public/js/main.js"></script>
    
</body>

</html>