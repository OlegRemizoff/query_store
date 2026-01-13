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


// Регистрация, авторизация и выход
if (isset($_POST['register'])) {
    registration();
    (header("Location: index.php"));
    die;
}








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
        <div class="row my-3">
            <div class="col">
                <?php if (!empty($_SESSION['errors'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['errors'];
                        unset($_SESSION['errors']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Форма регистрации -->
        <?php if (empty($_SESSION['username'])): ?>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h3>Регистрация</h3>
                </div>
            </div>
            <form action="index.php" method="post" class="row g-3">
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Имя">
                        <label for="floatingInput">Имя</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating">
                        <input type="password" name="pass" class="form-control" id="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">Пароль</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" name="register" class="btn btn-primary">Зарегистрироваться</button>
                </div>
            </form>
            <!-- End Форма регистрации-->

            <!-- Форма авторизации -->
            <div class="row mt-3">
                <div class="col-md-6 offset-md-3">
                    <h3>Авторизация</h3>
                </div>
            </div>

            <form action="index.php" method="post" class="row g-3">
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="login" class="form-control" id="floatingInput" placeholder="Имя">
                        <label for="floatingInput">Имя</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating">
                        <input type="password" name="pass" class="form-control" id="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">Пароль</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" name="auth" class="btn btn-primary">Войти</button>
                </div>
            </form>
            <!-- End Форма авторизации -->


        <?php else: ?>
            <!-- Форма сообщения -->
            <form action="index.php" method="post" class="row g-3 mb-5">
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating">
                        <textarea class="form-control" name="message" placeholder="Leave a comment here"
                            id="floatingTextarea" style="height: 100px;"></textarea>
                        <label for="floatingTextarea">Сообщение</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" name="add" class="btn btn-primary">Отправить</button>
                </div>
            </form>

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <p>Добро пожаловать, User! <a href="?do=exit">Log out</a></p>
                </div>
            </div>
            <!-- End Форма сообщения -->
        <?php endif; ?>


        <div class="row">
            <div class="col-md-6 offset-md-3">
                <hr>
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title">Автор: User</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis distinctio
                            est illum in ipsum nemo nostrum odit optio quibusdam velit. Commodi dolores dolorum ex facere
                            maiores porro, reprehenderit velit voluptatum.</p>
                        <p>Дата: 01.01.2000</p>
                    </div>
                </div>
            </div>
        </div>


    </div>














    <script src="#"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>