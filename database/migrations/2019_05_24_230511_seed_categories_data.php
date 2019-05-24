<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
                [
                        'name'        => '万花园',
                        'description' => '万花齐放发现美',
                ],
                [
                        'name'        => '技巧',
                        'description' => '鲜花种植及养护',
                ],
                [
                        'name'        => '问答',
                        'description' => '保持友善，互帮互助',
                ],
                [
                        'name'        => '公告',
                        'description' => '站点公告',
                ],
        ];

        //插入数据库
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //回滚迁移时会被调用
        DB::table('categories')->truncate();
    }
}
