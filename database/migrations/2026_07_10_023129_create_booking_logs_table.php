<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('customer_name');

            $table->string('cruise_name');

            $table->date('booking_date');

            $table->time('booking_time');

            $table->string('booking_status');

            $table->string('action');

            $table->string('performed_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_logs');
    }
};