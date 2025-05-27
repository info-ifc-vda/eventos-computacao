<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('event_pending_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid()->default(DB::raw('gen_random_uuid()'));
            $table->timestamp('created_at');
            $table->foreignId('payer_id');
            $table->foreignId('receiver_id');
            $table->foreignId('event_id');
            $table->string('payment_method', 20)->nullable();
            $table->timestamp('payment_date');

            $table->foreign('payer_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->foreign('event_id')->references('id')->on('events');
            $table->unique('uuid');
            $table->unique(['payer_id', 'receiver_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_pending_transactions');
    }
};
