<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Note;
use Faker\Generator as Faker;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
    ];
});
