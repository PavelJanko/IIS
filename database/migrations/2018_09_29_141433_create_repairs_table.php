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
                ->references('id')->on('devices')
                ->onDelete('cascade');

            $table->unsignedInteger('claimant_id');
            $table->foreign('claimant_id')
                ->references('id')->on('employees')
                ->onDelete('cascade');

            $table->unsignedInteger('repairer_id')->nullable();
            $table->foreign('repairer_id')
                ->references('id')->on('employees')
                ->onDelete('set null');
            $table->timestamp('repaired_at')->nullable();

            $table->string('state');

            $table->timestamp('claimed_at')->nullable();
            $table->timestamp('updated_at')->nullable();
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
