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
$factory->define(CodeProject\Entities\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(CodeProject\Entities\Client::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});

$factory->define(CodeProject\Entities\Project::class, function (Faker\Generator $faker) {

    return [
        'owner_id' => rand(1, 10),
        'client_id' => rand(1, 10),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'progress' => rand(1, 100),
        'status' => rand(1, 3),
        'due_date' => $faker->dateTime('now'),
    ];
});

$factory->define(CodeProject\Entities\ProjectNote::class, function (Faker\Generator $faker) {

    return [
        'project_id' => rand(1, 10),
        'title' => $faker->word,
        'note' => $faker->paragraph,
    ];
});

$factory->define(CodeProject\Entities\ProjectTask::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'project_id' => rand(1, 10),
        'start_date' => $faker->date,
        'due_date' => $faker->date,
        'status' => rand(1,3),
    ];
});

$factory->define(CodeProject\Entities\ProjectMembers::class, function (Faker\Generator $faker) {

    return [
        'project_id' => rand(1, 10),
        'user_id' => rand(1, 10),
    ];
});

$factory->define(CodeProject\Entities\OAuthClient::class, function (Faker\Generator $faker) {

    return [
        'id' => $faker->word,
        'secret' => $faker->word,
        'name' => $faker->word,
    ];
});



