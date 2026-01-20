<?php
error_reporting(E_ALL);



// Регистрация
if (isset($_POST['register'])) {
    registration();
    (header("Location: index.php?route=user"));
    exit();
}


// Авторизация
if (isset($_POST['auth'])) {
    login();
    header("Location: index.php?route=user");
    exit();
}


?>


    <!-- Форма регистрации -->
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3>Регистрация</h3>
        </div>
    </div>
    <form action="index.php?route=register" method="post" class="row g-3">
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
            <button type="submit" name="register" class="btn btn-secondary">Зарегистрироваться</button>
        </div>
    </form>
    <!-- End Форма регистрации-->

    <!-- Форма авторизации -->
    <div class="row mt-3">
        <div class="col-md-6 offset-md-3">
            <h3>Авторизация</h3>
        </div>
    </div>

    <form action="index.php?route=register" method="post" class="row g-3">
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
            <button type="submit" name="auth" class="btn btn-secondary">Войти</button>
        </div>
    </form>
    <!-- End Форма авторизации -->


