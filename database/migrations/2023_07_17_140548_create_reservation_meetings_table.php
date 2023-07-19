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
        Schema::create('reservation_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('room_id');
            $table->string('meeting_remark')->nullable();
            $table->string('person_name');
            $table->string('person_phone');
            $table->dateTime('date');
            $table->string('start');
            $table->string('end');
            $table->string('close_remark')->nullable();
            $table->string('close_image')->nullable();
            $table->unsignedInteger('user_id');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('reservation_meetings');
    }
};
