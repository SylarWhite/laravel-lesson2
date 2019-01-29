<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPremiumContentsToTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->longText('premium')->nullable()->comment('付费内容');
            $table->integer('price')->default(0)->comment('价格');
            $table->integer('buyer_count')->default(0)->comment('买家统计');
            $table->integer('amount')->default(0)->comment('已盈利');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('premium');
            $table->dropColumn('price');
            $table->dropColumn('buyer_count');
            $table->dropColumn('amount');
        });
    }
}
