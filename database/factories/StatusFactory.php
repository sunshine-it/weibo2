<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
// use Faker\Generator as Faker;
use Faker\Factory as Factory;

// 初始化 Faker\Factory 使用中文
$faker = Factory::create('zh_CN');
// 微博假数据 工厂类
$factory->define(App\Models\Status::class, function () use ($faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        // 'content'    => $faker->text(),
        'content'    => $faker->catchPhrase,
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
