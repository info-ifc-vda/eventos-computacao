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
        Schema::create('event_location', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreignId('address_id');
            $table->text('maps_link');

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->unique('event_id');
            $table->unique('address_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_location');
    }
};
