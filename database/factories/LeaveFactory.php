<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Leave;
use Faker\Generator as Faker;

$factory->define(Leave::class, function (Faker $faker) {
    return [
        'no_of_days' => 1,
        'start_date' => $faker->dateTimeBetween('now', '+1 day'),
        'end_date' => $faker->dateTimeBetween('now', '+1 day'),
        'leave_types_id' => 1,
        'applied_by' => 6,
        'approved_by' => null,
    ];
});

$factory->state(Leave::class, 'sick_leave', function () {
    return [
        'leave_types_id' => 2,
    ];
});

$factory->state(Leave::class, 'applied_by', function ($appliedBy) {
    return [
        'applied_by' => $appliedBy,
    ];
});