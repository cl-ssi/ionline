<?php

use Faker\Generator as Faker;

$factory->define(App\Resources\Telephone::class, function (Faker $faker) {
    // $telephone = Telephone::Create(['number'=>572539004, 'minsal'=>579004]);
    return [
        'number' => $faker->unique()->numberBetween($min = 572540000, $max = 572999999),
        'minsal' => $faker->unique()->numberBetween($min = 579600, $max = 579999),
    ];
});
