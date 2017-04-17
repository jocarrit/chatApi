<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Users\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Chats\Chat::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'user_id' => function () {
            return factory(App\Users\User::class)->create()->id;
        }
    ];
});

$factory->state(App\Chats\Chat::class, 'testing', function (Faker\Generator $faker) {

    return [
        'name' => 'testing',
        'user_id' => 88
    ];
});

$factory->state(App\Messages\Message::class, 'testing', function (Faker\Generator $faker) {
    return [
        'message' => 'testing',
        'user_id' => 88
    ];

});

$factory->define(App\Messages\Message::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'message' => $faker->sentence,
        'user_id' => function () {
            return factory(App\Users\User::class)->create()->id;
        },
        'chat_id' => function () {
            return factory(App\Chats\Chat::class)->create()->id;
        }
    ];
});