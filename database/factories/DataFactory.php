<?php

use App\Models\Data;
use Faker\Generator as Faker;

$factory->define(Data::class, fn(Faker $faker) => [
    'value' => $faker->randomDigit,
    'ip' => $faker->ipv4,
]);
