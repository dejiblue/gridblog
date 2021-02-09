<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Blog::class, function (Faker $faker) {
    return [
        'author'=> Auth::user()->id,
        'title' => $faker->sentence,
        'body' => $faker->sentence
    ];
});
