<?php
// database/migrations/2024_01_01_000002_create_attendances_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['hadir', 'belum_hadir'])->default('belum_hadir');
            $table->timestamp('scanned_at')->nullable();
            $table->string('scanned_by')->nullable(); // admin username
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
