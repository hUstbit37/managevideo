<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Test_search;
use Faker\Generator as Faker;

$factory->define(Test_search::class, function (Faker $faker) {
    return [
        // 'name' => $faker->sentence(3),
        'name' => 'Messi ' . Str::random(3),
        'age' => rand(15, 50),
        // 'school' => $faker->sentence(5),
        'school' => 'Bach khoa ' . Str::random(3),

    ];
});
