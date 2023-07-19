<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('capacity')->default(0);
            $table->json('tools')->nullable();
            $table->unsignedInteger('open_time')->default(0);
            $table->unsignedInteger('close_time')->default(47);
            $table->boolean('enable')->default(1)->index();
            $table->boolean('need_audit')->default(0);
            $table->unsignedInteger('order')->default(0)->index();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('meeting_rooms');
    }
};
