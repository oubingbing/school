<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExplorePlanetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('explore_planets', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable()->comment('行星的名称');
            $table->string('nickname')->comment('行星微信昵称');
            $table->string('email')->unique()->nullable()->index()->comment('备用的email,为以后登录预留');
            $table->string('password')->nullable()->comment('预留账号密码');
            $table->string('mobile')->nullable()->index()->comment('预留手机号码字段');

            $table->string('avatar')->nullable()->comment('微信头像');
            $table->tinyInteger('gender')->default(0)->comment('默认一个性别');
            $table->string('open_id')->nullable()->index();
            $table->string('union_id')->nullable()->index();
            $table->string('city')->default('无');
            $table->string('country')->default('无');
            $table->string('language')->default("zh_CN");
            $table->string('province')->default('无');

            $table->tinyInteger('type')->default(0)->comment('用户类型');
            $table->tinyInteger('status')->default(0)->comment('用户状态');

            $table->bigInteger('visit_number')->default(0)->comment('被造访次数');

            $table->rememberToken();

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
        Schema::table('explore_planets', function (Blueprint $table) {
            //
        });
    }
}
