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
        Schema::create('event_bank_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('event_id');
            $table->string('bank');
            $table->string('holder');
            $table->string('pix_key');

            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_bank_details');
    }
};
