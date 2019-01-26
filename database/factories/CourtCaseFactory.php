<?php

use Faker\Generator as Faker;
use App\CourtCase;
use Carbon\Carbon;

$factory->define(CourtCase::class, function (Faker $faker) {
    $courts = ['CourtA', 'CourtB', 'CourtC'];
    $hearingTypes = ['TypeA','TypeB','TypeC'];
    return [
        'name' => $faker->name(),
        'location' => $faker->randomElement( $courts ),
        'datetime' => Carbon::make( $faker->dateTimeBetween('now','3 days') ),
        'hearingType' => $faker->randomElement( $hearingTypes )
    ];
});
