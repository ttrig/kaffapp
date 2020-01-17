<?php

use App\Models\Device;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Device::class, fn(Faker $faker) => [
    'name' => $faker->userName,
    'api_token' => Str::random(60),
    'value_when_empty' => 0,
    'value_when_full' => 100,
    'capacity_in_cl' => 125,
    'minutes_to_brew' => 5,
    'fresh_for_minutes' => 30,
]);
