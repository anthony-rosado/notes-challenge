<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Attachment;
use Faker\Generator as Faker;

$factory->define(Attachment::class, function (Faker $faker) {
    return [
        'filename' => $faker->imageUrl(),
    ];
});
