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
        Schema::create('members', function (Blueprint $table) {
            // Primary key auto-increment
            $table->id();

            // Nama lengkap member
            $table->string('name', 150);

            // Kode member unik (Contoh: MBR-2025-001)
            $table->string('member_code', 20)->unique();

            // Alamat email unik
            $table->string('email', 150)->unique();

            // Nomor telepon
            $table->string('phone', 20)->nullable();

            // Alamat lengkap member
            $table->text('address')->nullable();

            // Status keanggotaan: active, inactive, atau suspended
            // Default diatur ke 'active'
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');

            // Tanggal member bergabung
            $table->date('joined_at')->nullable();

            // Kolom created_at dan updated_at 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};