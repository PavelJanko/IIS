<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('device_id');
            $table->foreign('device_id')
                ->references('id')->on('devices');

            $table->unsignedInteger('claimant_id');
            $table->foreign('claimant_id')
                ->references('id')->on('employees');

            $table->unsignedInteger('repairer_id')->nullable();
            $table->foreign('repairer_id')
                ->references('id')->on('employees');
            $table->timestamp('repaired_at')->nullable();

            $table->string('state');

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
        Schema::dropIfExists('repairs');
    }
}
