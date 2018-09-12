<?php

use Faker\Generator as Faker;

$factory->define(App\SubCategory::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name,
        'slug' => $name,
        'category_id' => rand(0,9),
    ];
});
