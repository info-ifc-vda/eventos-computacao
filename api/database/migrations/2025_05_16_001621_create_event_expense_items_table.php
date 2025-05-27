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
        Schema::create('event_expense_items', function (Blueprint $table) {
            $table->id();
            $table->uuid()->default(DB::raw('gen_random_uuid()'));
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('event_expense_id');
            $table->string('description', 255);
            $table->decimal('unit_value');
            $table->decimal('quantity');
            $table->decimal('discount');
            $table->decimal('total_value');

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
        Schema::dropIfExists('event_expense_items');
    }
};
