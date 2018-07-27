<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'slug' => $faker->slug,
    'title' => rtrim($faker->text(30), '.'),
    'text' => $faker->realText(),
    'created_at' => $faker->dateTimeBetween('-1 year', '-5 day')->format(DateTime::ATOM),
    'updated_at' => $faker->dateTimeBetween('-5 day')->format(DateTime::ATOM),
];
