<?php
// database/migrations/2024_01_01_000001_create_participants_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique(); // e.g. SPM-2026-0001
            $table->string('name');
            $table->enum('age_range', ['17-20', '21-25', '>25']);
            $table->string('phone');
            $table->string('institution');
            $table->enum('info_source', ['Sosial Media', 'Teman / Referral', 'Kampus / Komunitas', 'Online (Web/Email)']);
            $table->string('payment_proof'); // path to uploaded file
            $table->string('email');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('qr_code_path')->nullable(); // path to generated QR image
            $table->string('pdf_path')->nullable(); // path to generated PDF ticket
            $table->boolean('ticket_sent')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
