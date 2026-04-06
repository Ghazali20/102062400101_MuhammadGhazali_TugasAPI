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
        Schema::create('books', function (Blueprint $table) {
            // Primary key auto-increment
            $table->id();

            // Judul buku, maksimal 200 karakter
            $table->string('title', 200);

            // Nama penulis, maksimal 150 karakter
            $table->string('author', 150);

            // Kode ISBN unik, maksimal 20 karakter
            $table->string('isbn', 20)->unique();

            // Kategori / genre buku
            $table->string('category', 100)->nullable();

            // Nama penerbit [cite: 34, 80]
            $table->string('publisher', 150)->nullable();

            // Tahun terbit
            $table->year('year')->nullable();

            // Jumlah stok tersedia, default 0
            $table->integer('stock')->default(0);

            // Sinopsis / deskripsi buku
            $table->text('description')->nullable();

            // Kolom created_at dan updated_at 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};