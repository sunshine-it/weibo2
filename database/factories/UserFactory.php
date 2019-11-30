<?php

use App\Models\User;
use Illuminate\Support\Str;
// use Faker\Factory as Factory;

// 初始化 Faker\Factory 使用中文
// $faker = Factory::create('zh_CN');
// $factory->define(User::class, function () use($faker){
//     $date_time = $faker->date.' '.$faker->time;
//     return [
//         'name' => $faker->name,
//         'email' => $faker->unique()->safeEmail,
//         'email_verified_at' => now(),
//         'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
//         'remember_token' => Str::random(10),
//         'created_at' => $date_time,
//         'updated_at' => $date_time,
//     ];
// });

use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
