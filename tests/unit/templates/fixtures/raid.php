<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'slug' => $faker->slug,
    'name' => rtrim($faker->text(20), '.'),
    'subtitle' => rtrim($faker->text(40), '.'),
    'description' => rtrim($faker->realText(60), '.'),
    'image' => 'image.jpg',
    'is_active' => $faker->boolean(),
    'created_at' => $faker->dateTimeBetween('-1 year', '-5 day')->format(DateTime::ATOM),
    'updated_at' => $faker->dateTimeBetween('-5 day')->format(DateTime::ATOM),
];
