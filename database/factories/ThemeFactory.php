<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Themes\Theme::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'active' => $faker->boolean(80)
    ];
});
