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
        Schema::create('checklist', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->string('inner_code', 20);
            $table->dateTime('checkin_time');
            $table->boolean('checkin_operation');
            $table->dateTime('checkout_time');
            $table->boolean('checkout_operation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist');
    }
};
