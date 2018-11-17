<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');

            // Foreign key for user's department
            $table->unsignedInteger('department_id')->default(1);
            $table->foreign('department_id')
                ->references('id')->on('departments');

            // Foreign key for user's room
            $table->unsignedInteger('room_id')->nullable();
            $table->foreign('room_id')
                ->references('id')->on('rooms');

            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            $table->string('phone_number')->nullable();

            $table->string('street')->nullable();
            $table->unsignedInteger('building_number')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('employees');
    }
}
