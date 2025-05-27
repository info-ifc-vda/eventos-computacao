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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid()->default(DB::raw('gen_random_uuid()'));
            $table->timestamps();
            $table->foreignId('user_id');
            $table->string('title');
            $table->text('description');
            $table->timestamp('cancellation_date')->nullable();
            $table->text('cancellation_description')->nullable();
            $table->timestamp('subscription_deadline');
            $table->timestamp('payment_deadline')->nullable();
            $table->string('banner_url', 255);
            $table->decimal('estimated_value');

            $table->unique('uuid');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
