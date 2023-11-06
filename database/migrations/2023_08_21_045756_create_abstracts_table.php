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
        Schema::create('abstracts', function (Blueprint $table) {
            $table->id('id');
            $table->string('full_name');
            $table->string('contact_phone_number');
            $table->string('email', 50);
            $table->text('address');
            $table->double('no_of_pages');
            $table->string('abstract_title');
            $table->double('duration');
            $table->text('additional_information');
            $table->string('file');
            $table->foreignIdFor(\App\Models\Attendance::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('abstracts');
    }
};
