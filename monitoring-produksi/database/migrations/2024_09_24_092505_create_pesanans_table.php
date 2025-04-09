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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')
                ->constrained('pelanggans')
                ->cascadeOnDelete();
            $table->string('nomor_pesanan')->unique();
            $table->date('tgl_pesanan');
            $table->decimal('total_harga', 10,2,);
            $table->enum('status_pesanan', ['Baru', 'Diproses', 'Diambil', 'Dikirim', 'Selesai']);
            $table->enum('status_pembayaran', ['Belum Bayar', 'DP', 'Lunas']);
            // $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
