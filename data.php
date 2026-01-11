<?php


// MySQL напрямую
// INSERT INTO movies (title, release_year, country, director, description, rating, budget, duration_minutes)
// VALUES 
//     ('Амстердам', 2022, 'США', 'Дэвид О. Расселл', 'Blablabla', 6.3, 80000000, 134);


// Delete constraint table
// $sql_delete = <<<SQL
// DELETE FROM movies;
// DELETE FROM actors;
// ALTER TABLE movies AUTO_INCREMENT = 1;
// ALTER TABLE actors AUTO_INCREMENT = 1;
// SQL;


//==================================================================================================================

return [
    'movies' => [
        [
            'title' => 'Амстердам',
            'release_year' => 2022,
            'country' => 'США',
            'director' => 'Дэвид О. Расселл',
            'description' => 'Let the love, murder, and conspiracy begin',
            'rating' => 6.3,
            'budget' => 80000000,
            'duration_minutes' => 134,
            'img' => null,
            'film_actors' => ['Кристиан Бэйл', 'Марго Робби']
        ],
        [
            'title' => 'Вавилон',
            'release_year' => 2022,
            'country' => 'США',
            'director' => 'Дэмьен Шазелл',
            'description' => 'Always make a scene',
            'rating' => 7.4,
            'budget' => 78000000,
            'duration_minutes' => 189,
            'img' => null,
            'film_actors' => ['Марго Робби', 'Брэд Питт']
        ],
        [
            'title' => 'Однажды в… Голливуде',
            'release_year' => 2019,
            'country' => 'США',
            'director' => 'Квентин Тарантино',
            'description' => '9-й фильм Квентина Тарантино',
            'rating' => 7.7,
            'budget' => 90000000,
            'duration_minutes' => 161,
            'img' => null,
            'film_actors' => ['Марго Робби', 'Брэд Питт', 'Леонардо ДиКаприо']
        ],
        [
            'title' => 'Волк с Уолл-стрит (2013)',
            'release_year' => 2013,
            'country' => 'США',
            'director' => 'Мартин Скорсезе',
            'description' => 'Earn. Spend. Party',
            'rating' => 8.1,
            'budget' => 100000000,
            'duration_minutes' => 180,
            'img' => null,
            'film_actors' => ['Марго Робби', 'Леонардо ДиКаприо', 'Мэттью Макконахи']
        ],
        [
            'title' => 'Интерстеллар',
            'release_year' => 2014,
            'country' => 'США',
            'director' => 'Кристофер Нолан',
            'description' => 'Следующий шаг человечества станет величайшим',
            'rating' => 8.7,
            'budget' => 165000000,
            'duration_minutes' => 169,
            'img' => null,
            'film_actors' => ['Мэттью Макконахи', 'Энн Хэтэуэй']
        ],
        [
            'title' => 'Темный рыцарь: Возрождение легенды',
            'release_year' => 2012,
            'country' => 'США',
            'director' => 'Кристофер Нолан',
            'description' => 'И разгорится пламя',
            'rating' => 8.2,
            'budget' => 250000000,
            'duration_minutes' => 165,
            'img' => null,
            'film_actors' => ['Кристиан Бэйл', 'Энн Хэтэуэй']
        ],
    ],
    'actors' => [
        [
            'actor_name' => 'Брэд Питт',
            'birth_year' => '1963-12-18',
            'country' => 'США',
            'img' => null
        ],
        [
            'actor_name' => 'Марго Робби',
            'birth_year' => '1990-07-02',
            'country' => 'Австралия',
            'img' => null
        ],
        [
            'actor_name' => 'Леонардо ДиКаприо',
            'birth_year' => '1974-11-11',
            'country' => 'США',
            'img' => null
        ],
        [
            'actor_name' => 'Мэттью Макконахи',
            'birth_year' => '1969-11-04',
            'country' => 'США',
            'img' => null
        ],
        [
            'actor_name' => 'Энн Хэтэуэй',
            'birth_year' => '1982-11-12',
            'country' => 'США',
            'img' => null
        ],
        [
            'actor_name' => 'Кристиан Бэйл',
            'birth_year' => '1974-01-30',
            'country' => 'Великобритания',
            'img' => null
        ],
        
    ],
];



