<?php
error_reporting(E_ALL);





$user_id = $_SESSION['user']['id'] ?? null;
$query_id = $_POST['query_id'] ?? null;


if (isset($_POST['add'])) {
    add_query();
    header("Location: index.php?route=user");
}



// Получаем все запросы пользователя 
// для вывода их в select
$stmt = $db->prepare(
    "SELECT users.id, queries.id, title, query  
    FROM users
    LEFT JOIN queries ON users.id = queries.user_id
    WHERE users.id = ?;
    "
);
$stmt->execute([$user_id]);
$all_queries = $stmt->fetchAll();






// Получаем id для поиска
// и последующего вывода в textarea
if (isset($_POST['show']) && $query_id) {
    $stmt = $db->prepare(
        "SELECT 
            query 
        FROM 
            queries 
        WHERE id = ?"
    );
    $stmt->execute([$query_id]);
    $sql = $stmt->fetchColumn(); // sql запрос |  SELECT title FROM movies LIMIT 1;   


    $stmt1 = $db->query($sql);
    $result = $stmt1->fetchAll(); // результат | { ["title"]=> string(18) "Амстердам" [0]=> string(18) "Амстердам" } }

    
}






?>

<?php if (!empty($_SESSION['user']['username'])): ?>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <p>Добро пожаловать, <b><?php echo $_SESSION['user']['username'] ?></b>! <a href="index.php?route=logout">Log out</a></p>
        </div>
    </div>


    <!-- Выполнение запроса -->
    <form action="index.php?route=user" method="post" class="row g-3 mb-5">
        <div class="col-md-6 offset-md-3">
            <!-- <label for="querySelect" class="form-label">Выберите интересующий вас запрос:</label> -->
            <select id="querySelect" name="query_id" class="form-select" aria-label="Default select example">
                <option selected disabled>Выбрать запрос</option>
                <?php foreach ($all_queries as $query): ?>
                    <option value="<?= $query['id'] ?>"><?= $query['title'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6 offset-md-3">
            <div class="form-floating">
                <textarea class="form-control" name="sql" placeholder="Leave a sql here"
                    id="floatingTextarea" style="height: 100px;">
                <?php if (!empty($sql)): ?>
                    <?= $sql ?>
                <?php endif; ?>
                </textarea>
                <label for="floatingTextarea">Текст запроса (только чтение)</label>
            </div>
        </div>

        <div class="col-md-6 offset-md-3 d-flex justify-content-end">
            <button type="submit" name="show" class="btn btn-primary">Выполнить</button>
        </div>
    </form>
    <!-- End выполнение запроса -->


    <!-- Форма нового запроса -->
    <div class="col-md-6 offset-md-3">
        <img src="/static/img//query_store.svg" class="img-fluid" alt="...">
    </div>
    <form action="index.php?route=user" method="post" class="row g-3 mb-5">
        <div class="col-md-6 offset-md-3">
            <div class="form-floating mb-3">
                <input type="text" name="title" class="form-control" id="floatingInput" placeholder="">
                <label for="floatingInput">Название запроса</label>
            </div>
        </div>
        <div class="col-md-6 offset-md-3">
            <div class="form-floating">
                <textarea class="form-control" name="query" placeholder="Leave a sql here"
                    id="floatingTextarea" style="height: 100px;"></textarea>
                <label for="floatingTextarea">Текст запроса</label>
            </div>
        </div>

        <div class="col-md-6 offset-md-3 d-flex justify-content-end">
            <button type="submit" name="add" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
    <!-- End Форма нового запроса -->



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

        <div class="col-md-6 offset-md-3 d-flex justify-content-end">
            <button type="submit" name="auth" class="btn btn-primary">Войти</button>
        </div>
    </form>
    <!-- End Форма авторизации -->
<?php endif ?>









<?php
