<?php
error_reporting(E_ALL);






$stmt = $db->prepare(
    "SELECT users.id, username, title, query  
    FROM users
    LEFT JOIN queries ON users.id = queries.user_id
    ORDER BY username;
    ");
$stmt->execute();
$allQueries = $stmt->fetchAll();





?>

<div class="container">

    <!-- Navbar -->
    <?php include_once "templates/navbar.html" ?>
    <!-- End navbar -->

    <!-- Alerts -->
    <?php include_once "templates/alert.html" ?>
    <!-- End alerts -->

    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Пользователь</th>
                        <th scope="col">Название</th>
                        <th scope="col">Текст запроса</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($allQueries)): ?>
                    <?php foreach ($allQueries as $query): ?> 
                    <tr>
                        <td> <?= $query['username'] ?? "" ?> </td>
                        <td> <?= $query['title'] ?? "Пусто" ?> </td>
                        <td> <?= $query['query'] ?? "Пусто" ?> </td>
                    </tr>
                    <?php endforeach; ?> 
                <?php else: ?>
                    <tr>
                        <td>Пользователей нет</td>
                        <td>Пусто</td>
                        <td>Пусто</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>