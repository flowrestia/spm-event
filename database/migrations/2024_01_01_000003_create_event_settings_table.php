<?php
// database/migrations/2024_01_01_000003_create_event_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('form_open')->default(true);
            $table->string('header_image')->nullable();
            $table->timestamps();
        });

        // Seed default setting
        DB::table('event_settings')->insert([
            'form_open' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('event_settings');
    }
};
