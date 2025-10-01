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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('idTransaksi');
            $table->unsignedBigInteger('idBuku');
            $table->unsignedBigInteger('idPeminjam');
            $table->date('tglPinjam');
            $table->date('tglKembali')->nullable();
            $table->decimal('denda', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('idBuku')->references('idBuku')->on('buku');
            $table->foreign('idPeminjam')->references('idPeminjam')->on('peminjam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
