<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('accommodations', function (Blueprint $table) {
            $table->double('total_amount')->default(0)->after('isPaid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('accommodations', function (Blueprint $table) {
            $table->dropColumn('total_amount');
        });
    }
};
