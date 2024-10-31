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
        Schema::table('checklist', function (Blueprint $table) {
            //
            $table->string('checkin_place',10)->default('jinde');
            $table->string('checkout_place',10)->default('jinde');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checklist', function (Blueprint $table) {
            //
            $table->dropColumn('checkin_place');
            $table->dropColumn('checkout_place');
        });
    }
};
