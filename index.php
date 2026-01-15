<?php
session_start();
error_reporting(E_ALL);


require_once 'functions.php';



// Подключение к БД
$config = parse_ini_file('.env');

$db_host = $config['DB_HOST'] ?? 'localhost';
$db_name   = $config['DB_DATABASE'] ?? 'query_store';
$db_user = $config['DB_USERNAME'] ?? 'root';
$db_pass = $config['DB_PASSWORD'] ?? '';

$db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass);



// Проверяет есть ли нужные таблицы и заполняет их дынными
check();


// Регистрация
if (isset($_POST['register'])) {
    registration();
    (header("Location: index.php"));
    die;
}




// Авторизация
if (isset($_POST['auth'])) {
    login();
    (header("Location: index.php"));
    die;
}


if (isset($_GET['do'])) {
    if ($_GET['do'] == 'exit') {
        logout();
        (header("Location: index.php"));
        die;
    }
}



// SQL Query

if (isset($_POST['add'])) {
    add_query();
}















// SELECT * FROM actors LIMIT 1;
// $stmt = $db->prepare("SELECT * FROM movies");
// $stmt->execute();
// $movies = $stmt->fetchAll();

// debug($movies);




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
        <?php if (empty($_SESSION['user']['username'])): ?>
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
                    <button type="submit" name="auth" class="btn btn-primary">Войти</button>
                </div>
            </form>
            <!-- End Форма авторизации -->


        <?php else: ?>

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <p>Добро пожаловать, <b><?php echo $_SESSION['user']['username'] ?></b>! <a href="?do=exit">Log out</a></p>
                </div>
            </div>

            <!-- Форма сообщения -->
            <form action="index.php" method="post" class="row g-3 mb-5">
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="title" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Title</label>
                    </div>
                </div>
                <div class="col-md-6 offset-md-3">
                    <div class="form-floating">
                        <textarea class="form-control" name="query" placeholder="Leave a sql here"
                            id="floatingTextarea" style="height: 100px;"></textarea>
                        <label for="floatingTextarea">SQL Query</label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" name="add" class="btn btn-primary">Отправить</button>
                </div>
            </form>
            <!-- End Форма сообщения -->
        <?php endif; ?>




    </div>














    <script src="#"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>