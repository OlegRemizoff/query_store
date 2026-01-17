<?php
error_reporting(E_ALL);


if (isset($_POST['add'])) {
    add_query();
    header("Location: index.php?route=home");
}

?>

<?php if (!empty($_SESSION['user']['username'])): ?>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <p>Добро пожаловать, <b><?php echo $_SESSION['user']['username'] ?></b>! <a href="index.php?route=logout">Log out</a></p>
        </div>
    </div>

    <!-- Форма сообщения -->
    <form action="index.php?route=user" method="post" class="row g-3 mb-5">
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
            <button type="submit" name="add" class="btn btn-primary">Добавить запрос</button>
        </div>
    </form>
    <!-- End Форма сообщения -->
    <?php else: ?>
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
            <button type="submit" name="auth" class="btn btn-primary">Войти</button>
        </div>
    </form>
    <!-- End Форма авторизации -->
<?php endif ?>









<?php


