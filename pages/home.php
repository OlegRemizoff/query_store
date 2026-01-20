<?php
error_reporting(E_ALL);





$all_queries = $db->query("
    SELECT username, users.id, title, query  
    FROM users
    LEFT JOIN queries ON users.id = queries.user_id
    ORDER BY username
")->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);




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
                        <th>Название</th>
                        <th>Текст запроса</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_queries as $username => $queries): ?>
                        <tr class="table-secondary">
                            <td colspan="2"><strong>👤 <?= $username ?></strong></td>
                        </tr>

                        <?php foreach ($queries as $query): ?>
                            <tr>
                                <td><?= $query['title'] ?? '—' ?></td>
                                <td><code><?= $query['query'] ?? '—' ?></code></td>
                            </tr>
                        <?php endforeach; ?>

                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>