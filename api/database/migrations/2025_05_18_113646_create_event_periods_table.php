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
        Schema::create('event_periods', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');
            $table->foreignId('event_id');
            $table->date('date');
            $table->time('opening_time');
            $table->time('closing_time');

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
        Schema::dropIfExists('event_periods');
    }
};
