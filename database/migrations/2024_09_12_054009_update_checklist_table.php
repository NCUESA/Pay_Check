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
            $table->string('checkin_time')->nullable()->change();
            $table->string('checkout_time')->nullable()->change();
            $table->integer('checkin_operation')->default(0)->change();
            $table->integer('checkout_operation')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checklist', function (Blueprint $table) {
            //
        });
    }
};
