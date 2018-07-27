<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'raid_id' => random_int(1, 4),
    'slug' => $faker->slug,
    'type' => 'text',
    'name' => rtrim($faker->text(15), '.'),
    'content' => $faker->realText(),
    'is_default' => $faker->boolean(),
    'created_at' => $faker->dateTimeBetween('-1 year', '-5 day')->format(DateTime::ATOM),
    'updated_at' => $faker->dateTimeBetween('-5 day')->format(DateTime::ATOM),
];
