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
        Schema::create('event_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->timestamp('created_at');
            $table->foreignId('event_id');
            $table->foreignId('event_pending_transaction_id')->nullable();
            $table->foreignId('event_expense_id')->nullable();
            $table->decimal('credit');
            $table->decimal('debit');

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('event_pending_transaction_id')->references('id')->on('event_pending_transactions');
            $table->foreign('event_expense_id')->references('id')->on('event_expenses');

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
        Schema::dropIfExists('event_transactions');
    }
};
