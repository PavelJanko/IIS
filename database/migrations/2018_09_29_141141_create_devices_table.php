<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('keeper_id');
            $table->foreign('keeper_id')
                ->references('id')->on('employees');

            $table->unsignedInteger('room_id')->nullable();
            $table->foreign('room_id')
                ->references('id')->on('rooms');

            $table->string('serial_number')->unique();
            $table->string('name');
            $table->string('type');
            $table->string('manufacturer');

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
        Schema::dropIfExists('devices');
    }
}
