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
        Schema::create('events_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');   
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('cascade'); 
            $table->string('title');
            $table->string('first_name');
            $table->string('surname');
            $table->string('phone_number');
            $table->string('email');
            $table->string('gender');
            $table->string('nature_practice');
            $table->string('institution');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('nationality');
            $table->boolean('paid')->default(false);
            $table->string('payment_ref')->nullable();
            $table->string('payment_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_users');
    }
};
