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

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('unique_id');
            $table->string('slug');
            $table->string('location');
            $table->decimal('regular_price', 8, 2)->nullable();
            $table->decimal('exhibition_price', 8, 2)->nullable();
            $table->decimal('speaker_price', 8, 2)->nullable();
            $table->longText('description')->nullable();
            $table->date('date')->nullable();
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
