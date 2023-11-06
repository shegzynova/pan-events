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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->string('nature_of_practice')->nullable();
            $table->string('institution')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->default('draft');
            $table->string('surname')->nullable();
            $table->string('gender')->nullable();
            $table->string('education_level')->nullable();
            $table->string('employment_status')->nullable();
            $table->foreignIdFor(\App\Models\Event::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
