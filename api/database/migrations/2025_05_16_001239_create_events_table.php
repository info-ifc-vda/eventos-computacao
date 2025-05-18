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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->timestamps();
            $table->softDeletes();
            $table->string('title');
            $table->text('description');
            $table->timestamp('cancellation_date')->nullable();
            $table->text('cancellation_description')->nullable();
            $table->timestamp('confirmation_deadline');
            $table->timestamp('payment_deadline')->nullable();
            $table->string('banner_url', 255);
            $table->decimal('estimated_value');
            $table->smallInteger('public_event');
            $table->timestamp('event_completion_date')->nullable();

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
        Schema::dropIfExists('events');
    }
};
