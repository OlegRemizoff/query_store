<?php



// Красивая распечатка массива
function debug($data)
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
}


// Создание таблиц
function create_tables()
{
    global $db;

    $sql = <<<SQL
    
    CREATE TABLE IF NOT EXISTS users 
    (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        pass VARCHAR(255) NOT NULL

    );

    CREATE TABLE IF NOT EXISTS queries
    (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        query TEXT NOT NULL,
        FOREIGN KEY (user_id)  REFERENCES users (id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT EXISTS movies
    (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        release_year INT UNSIGNED NOT NULL,
        country  VARCHAR(255) NOT NULL,
        director VARCHAR(255) NOT NULL,
        description TEXT,
        rating FLOAT,
        budget INT NOT NULL,
        duration_minutes INT NOT NULL,
        img VARCHAR (255)
    );

    CREATE TABLE IF NOT EXISTS actors
    (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        actor_name VARCHAR(255) NOT NULL,
        birth_year DATE NOT NULL,
        country  VARCHAR(255) NOT NULL,
        img VARCHAR(255)
    );

    CREATE TABLE IF NOT EXISTS movie_actor
    (
        movie_id INT UNSIGNED,
        actor_id INT UNSIGNED,

        PRIMARY KEY (movie_id, actor_id),

        FOREIGN KEY (movie_id)  REFERENCES movies (id) ON DELETE CASCADE,
        FOREIGN KEY (actor_id)  REFERENCES actors (id) ON DELETE CASCADE

    );

    SQL;


    try {
        $db->exec($sql);
    } catch (Exception $e) {
        $_SESSION['errors'] = "Ошибка при создании таблиц <br> {$e}";
    }
}


// Заполнение таблиц
function filing_database()
{
    global $db;

    $movie_sql = <<<SQL
        INSERT INTO movies (title, release_year, country, director, description, rating, budget, duration_minutes, img)
        VALUES (:title, :release_year, :country, :director, :description, :rating, :budget, :duration_minutes, :img)
    SQL;


    $actor_sql = <<<SQL
        INSERT INTO actors (actor_name, birth_year, country, img)
        VALUES (:actor_name, :birth_year, :country, :img)
    SQL;



    $data  = require_once 'data.php';
    $movies_data = $data['movies'];
    $actors_data = $data['actors'];


    try {
        $db->beginTransaction();

        $actors_stmt = $db->prepare($actor_sql);
        foreach ($actors_data as $actor) {
            $actors_stmt->execute($actor);
        }

        // Вариант отличается, т.к нужно явно исключить film_actors 
        $movies_stmt = $db->prepare($movie_sql);
        foreach ($movies_data as $movie) {
            $movies_stmt->execute([
                ':title'            => $movie['title'],
                ':release_year'     => $movie['release_year'],
                ':country'          => $movie['country'],
                ':director'         => $movie['director'],
                ':description'      => $movie['description'],
                ':rating'           => $movie['rating'],
                ':budget'           => $movie['budget'],
                ':duration_minutes' => $movie['duration_minutes'],
                ':img'              => $movie['img']
            ]);
            // echo '<pre>' . print_r($movie, 1) . '</pre>';


            // Заполнение таблицы movie_actor
            $movieId = $db->lastInsertId();
            foreach ($movie['film_actors'] as $actor) {
                $stmtMovie = $db->prepare("SELECT id FROM actors WHERE actor_name = ?");
                $stmtMovie->execute([$actor]);
                $actorId = $stmtMovie->fetchColumn();


                $stmtLink = $db->prepare("INSERT INTO movie_actor (actor_id, movie_id) VALUES (?, ?)");
                $stmtLink->execute([$actorId, $movieId]);
            }
        }

        $db->commit();
        echo "Все данные успешно добавлены!";
    } catch (Exception $e) {
        $db->rollBack(); // Откат таблиц к прежнему состоянию
        $_SESSION['errors'] = "Ошибка при заполнении таблиц: " . $e->getMessage();
    }
}


// Проверяет есть ли нужные таблицы и заполняет дынными из массива data.php
function check()
{
    global $db;


    $stmt0 = $db->prepare("
    SELECT 
        TABLE_NAME 
    FROM 
        information_schema.TABLES 
    WHERE 
        TABLE_SCHEMA = 'query_store' AND TABLE_NAME IN ('movies', 'users')");

    $stmt0->execute();
    $existing_tables = $stmt0->fetchAll();
    if (empty($existing_tables)) {
        create_tables();
    }


    $stmt1 = $db->prepare("SELECT COUNT(id) FROM actors");
    $stmt1->execute();
    $actors = $stmt1->fetchColumn();

    if ($actors <= 0) {
        filing_database();
    }
}


// Удаляет данные из таблиц: actors, movies, actor_movie
function drop_tables()
{
    global $db;

    $sql = <<<SQL

    DELETE FROM movie_actor;
    DELETE FROM movies;
    DELETE FROM actors;
    ALTER TABLE movies AUTO_INCREMENT = 1;
    ALTER TABLE actors AUTO_INCREMENT = 1;

    SQL;

    $stmt = $db->prepare($sql);
    $stmt->execute();
}


// Регистрация нового пользователя
function registration(): bool
{

    global $db;

    $username = !empty($_POST['username']) ? trim($_POST['username']) : '';
    $pass = !empty($_POST['pass']) ? trim($_POST['pass']) : '';

    if (empty($username) || empty($pass)) {
        $_SESSION['errors'] = "Поля: имя/пароль обязательны";
        return false;
    }

    $res = $db->prepare("SELECT COUNT(id) FROM users WHERE username = ?");
    $res->execute([$username]);
    if ($res->fetchColumn()) {
        $_SESSION['errors'] = 'Ошибка: Пользователь с таким именем уже существует';
        return false;
    }

    $pass = password_hash($pass, PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO users (username, pass) VALUES(?, ?)");
        $stmt->execute([$username, $pass]);
        $_SESSION['success'] = 'Регистрация прошла успешно';
        return true;
    } catch (Exception $e) {
        $_SESSION['errors'] = $e->getMessage();
        return false;
    }
}


