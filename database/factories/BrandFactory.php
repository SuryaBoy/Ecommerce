<?php

use Faker\Generator as Faker;

$factory->define(App\Brand::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name,
        'slug' => $name,
    ];
});
