<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $x=str_random(10),
        'slug' => $x,
        'description' => $faker->text,
        'price' => rand(999,100000),
        'quantity' => rand(9,100),
        'image' => "files/default.jpg",
        'sub_category_id' => rand(1,13),
        'brand_id' => rand(1,10),
    ];
});
