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
        Schema::create('car_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('photos')->nullable(); // JSON array
            $table->string('type')->nullable(); // Yuk tashuvchi / Yengil / Odam tashuvchi
            $table->string('name')->nullable(); // Mashina nomi
            $table->string('color')->nullable(); // Rangi
            $table->string('step')->default('start'); // Qaysi bosqichda turibdi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_ads');
    }
};
