<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('cruises', function (Blueprint $table) {

        $table->id();

        $table->string('cruise_name');

        $table->string('destination');

        $table->string('departure_port');

        $table->text('description')->nullable();

        $table->string('image')->nullable();

        $table->integer('capacity');

        $table->integer('available_slots');

        $table->date('departure_date');

        $table->time('departure_time');

        $table->date('arrival_date');

        $table->decimal('ticket_price',10,2);

        $table->enum('status',[
            'Available',
            'Limited Slots',
            'Fully Booked',
            'Cancelled'
        ])->default('Available');

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cruises');
    }
};
