<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $categroies = [
            [
                'name'        => '图片区',
                'description' => '每日新图',
            ],
            [
                'name'        => '视频区',
                'description' => '短视频在线',
            ],
            [
                'name'        => 'T台区',
                'description' => '网友晒贴',
            ],
            [
                'name'        => '认证区',
                'description' => '站长认证',
            ],
        ];
        \Illuminate\Support\Facades\DB::table('categories')->insert($categroies);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        \Illuminate\Support\Facades\DB::table('categories')->truncate();
    }
}
