<?php
error_reporting(E_ALL);



$user_id = $_SESSION['user']['id'] ?? null;
$query_id = $_POST['query_id'] ?? null;


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

<!-- Logout -->
<?php if (!empty($_SESSION['user']['username'])): ?>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <p>Добро пожаловать, <b><?php echo $_SESSION['user']['username'] ?></b>! <a href="index.php?route=logout">Log out</a>
        </div>
    </div>

    <div class="container">
        <!-- Выполнение запроса | $sql -->
        <form action="index.php?route=user" method="post" class="row g-3 mb-5">
            <div class="col-md-8 offset-md-2">
                <div class="border-bottom pb-2 mb-4">
                    <h3 class="fw-light">Список запросов</h3>
                </div>
                <!-- <label for="querySelect" class="form-label">Выберите интересующий вас запрос:</label> -->
                <select id="querySelect" name="query_id" class="form-select" aria-label="Default select example">
                    <option selected disabled>Выбрать запрос</option>
                    <?php foreach ($all_queries as $query): ?>
                        <option value="<?= $query['id'] ?>"><?= $query['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-8 offset-md-2">
                <div class="form-floating">
                    <textarea class="form-control" name="sql" placeholder="Leave a sql here"
                        id="floatingTextarea" style="height: 300px;"><?php if (!empty($sql)) echo htmlspecialchars($sql); ?></textarea>
                    <label for="floatingTextarea">Текст запроса (только чтение)</label>
                </div>
            </div>

            <div class="col-md-8 offset-md-2 d-flex justify-content-end">
                <button type="submit" name="show" class="btn btn-light">Выполнить</button>
            </div>
        </form>
        <!-- End выполнение запроса | $sql -->


        <!-- Отображение выполненного запроса | $result -->
        <?php if (isset($result)): ?>
            <div class="row">
                <div class="col-md-8 offset-md-2 mb-3">
                    <table class="table table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <?php
                                // Cоздание заголовков
                                if (!empty($result)) {
                                    $firstRow = reset($result);
                                    foreach ($firstRow as $key => $value) {
                                        if (!is_numeric($key)) {
                                            echo '<th scope="col">' . $key . '</th>';
                                        }
                                    }
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $arr): ?>
                                <tr>
                                    <?php foreach ($arr as $key => $value): ?>
                                        <?php if (!is_numeric($key)): ?>
                                            <td><?= $value ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
        <!-- End отображение выполненного запроса | $result -->



        <!-- Форма нового запроса -->
        <div class="col-md-8 offset-md-2">
            <div class="border-bottom pb-2 mb-4">
                <h3 class="fw-light">Создать новый запрос</h3>
            </div>
        </div>
        <!-- Структура бд -->
        <div class="col-md-8 offset-md-2 mb-3">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Посмотреть структуру БД
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body text-center">
                            <img src="/public/img/query_store.svg" class="img-fluid rounded" alt="Пример изображения">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End структура бд -->
        <form action="index.php?route=user" method="post" id="addQueryForm" class="row g-3 mb-5">
            <div class="col-md-8 offset-md-2">
                <div class="form-floating mb-3">
                    <input type="text" name="title" class="form-control" id="floatingInput" placeholder="">
                    <label for="floatingInput">Название</label>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <div class="form-floating">
                    <textarea class="form-control" name="query" placeholder="Leave a sql here"
                        id="floatingTextarea" style="height: 300px;"></textarea>
                    <label for="floatingTextarea">Текст</label>
                </div>
            </div>

            <input type="hidden" name="addAjaxQuery" value="1">
            <div class="col-md-8 offset-md-2 d-flex justify-content-end">
                <button type="submit" name="add" class="btn btn-light" id="btn-add-submit">Сохранить</button>
            </div>
        </form>
        <!-- End Форма нового запроса -->

        <!-- Результат запроса -->
        <div class="col-md-8 offset-md-2">
            <div id="table-container"></div>
            <div id="movie-list"></div>
                
        </div>

        <!-- Форма изменения запроса -->
        <form action="index.php?route=user" method="post" class="row g-3 mb-5">
            <div class="col-md-8 offset-md-2">
                <div class="border-bottom pb-2 mb-4">
                    <h3 class="fw-light">Изменение запроса</h3>
                </div>
                <!-- <label for="querySelect" class="form-label">Выберите интересующий вас запрос:</label> -->
                <select id="querySelect" name="query_id" class="form-select" aria-label="Default select example">
                    <option selected disabled>Выбрать запрос</option>
                    <?php foreach ($all_queries as $query): ?>
                        <option value="<?= $query['id'] ?>"><?= $query['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-8 offset-md-2">
                <div class="form-floating">
                    <textarea class="form-control" name="rewrite_sql" placeholder="Leave a sql here"
                        id="floatingTextarea" style="height: 300px;"><?php if (!empty($sql)) echo htmlspecialchars($sql); ?></textarea>
                    <label for="floatingTextarea">Введите новый запрос</label>
                </div>
            </div>

            <div class="col-md-8 offset-md-2 d-flex justify-content-end">
                <button type="submit" name="rewrite" class="btn btn-light">Выполнить</button>
            </div>
        </form>
        <!-- End форма изменения запроса -->




    </div>


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
            <button type="submit" name="auth" class="btn btn-secondary">Войти</button>
        </div>
    </form>
    <!-- End Форма авторизации -->
<?php endif ?>
























<?php
