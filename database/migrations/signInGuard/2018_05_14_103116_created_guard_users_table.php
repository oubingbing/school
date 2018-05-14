<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedGuardUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guard_users', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('nickname')->comment('用户昵称');
            $table->string('mobile')->nullable()->index()->comment('预留手机号码字段');
            $table->string('avatar')->nullable()->comment('微信头像');

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
        //
    }
}
