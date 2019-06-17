<?php

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence(),
        'price' => $faker->randomFloat( nbMaxDecimals:2, min:100, max:1000)
    ];
});