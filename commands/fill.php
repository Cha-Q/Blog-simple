<?php
    require dirname(__DIR__) . '/vendor/autoload.php';

    use App\Connection;

    $faker = Faker\Factory::create('fr_FR');

    $pdo = Connection::getPDO();

    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    $pdo->exec('TRUNCATE TABLE post_category');
    $pdo->exec('TRUNCATE TABLE post');
    $pdo->exec('TRUNCATE TABLE category');
    $pdo->exec('TRUNCATE TABLE user');
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

    echo($faker->iso8601);
    $posts = [];
    $categories = [];

    for($i=0; $i< 50; $i++){
        $pdo->exec("INSERT INTO post SET name='{$faker->sentence(3)}', slug ='{$faker->slug}', created_at='{$faker->date} {$faker->time}', content = '{$faker->paragraphs(3, true)}'");
        $posts[] = $pdo->lastInsertId();
    }

    for($i=0; $i< 5; $i++){
        $pdo->exec("INSERT INTO category SET name='{$faker->word}', slug ='{$faker->slug}'");
        $categories[] = $pdo->lastInsertId();
    }

    foreach($posts as $post){
        $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
        foreach($randomCategories as $randomCategory){
            $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$randomCategory");
        }
    }

    $password = password_hash('root', PASSWORD_BCRYPT);
    $pdo->exec("INSERT INTO user SET username='admin', password='$password'");

