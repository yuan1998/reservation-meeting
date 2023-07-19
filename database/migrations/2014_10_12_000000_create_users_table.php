<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('nike_name')->nullable();
            $table->string('language')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->integer('gender')->default(0);
            $table->string('openid')->index()->unique();
            $table->string('session_key')->nullable();
            $table->string('unionid')->nullable();
            $table->boolean('enable')->default(1);
            $table->timestamps();
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
};
