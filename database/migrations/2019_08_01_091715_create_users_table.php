<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name')->nullable();
            $table->date('dob')->nullable()->comment('date of birth');
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->text('description')->nullable();
            $table->integer('role_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
