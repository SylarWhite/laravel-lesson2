<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        // ID 用户组
        $user_ids = User::all()->pluck('id')->toArray();

        // 分类ID
        $categories_ids = \App\Models\Category::all()->pluck('id')->toArray();

        // 获取实例
        $faker = app(Faker\Generator::class);



        $topics = factory(Topic::class)->times(100)->make()->each(function ($topic, $index) use ($user_ids,$categories_ids,$faker) {
            $topic->user_id = $faker->randomElement($user_ids);
            $topic->category_id = $faker->randomElement($categories_ids);
        });

        Topic::insert($topics->toArray());
    }

}

