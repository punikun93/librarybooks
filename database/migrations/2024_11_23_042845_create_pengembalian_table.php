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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id('PengembalianID');
            $table->unsignedInteger('PeminjamanID');
            $table->unsignedInteger('BukuID');
            $table->date('TanggalPengembalian');
            $table->enum('Status', ['proses', 'done']);
            $table->foreign('PeminjamanID')->references('PeminjamanID')->on('peminjaman')->onDelete('cascade');
            $table->foreign('BukuID')->references('BukuID')->on('buku')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
