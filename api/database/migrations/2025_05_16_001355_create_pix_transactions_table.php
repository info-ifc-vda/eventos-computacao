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
        Schema::create('pix_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->timestamp('created_at');
            $table->foreignId('event_pending_transaction_id');
            $table->decimal('value');
            $table->string('tx_id', 255);
            $table->timestamp('payment_date');
            $table->timestamp('expiration_date');

            $table->foreign('event_pending_transaction_id')->references('id')->on('event_pending_transactions');
            $table->unique('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pix_transactions');
    }
};
