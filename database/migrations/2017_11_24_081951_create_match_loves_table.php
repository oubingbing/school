<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchLovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_loves', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('owner_id')->index()->comment('所有者');

            $table->string('my_name')->index()->comment('我的名字');
            $table->string('love_name')->index('喜欢的人');
            $table->longText('content')->nullable()->comment('想对他说的话');

            $table->tinyInteger('is_password')->defalu(1)->comment('是否需要密码,默认需要');
            $table->string('password')->comment('设定的密码');
            $table->tinyInteger('type')->default(1)->comment('类型,是否匿名,默认匿名');
            $table->tinyInteger('status')->defauult(1)->commnet('预留字段');

            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable()->index();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match_loves');
    }
}
