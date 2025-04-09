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
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id')->nullable();
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_pelanggan');
            $table->enum('jenis_pembayaran', ['DP', 'Pelunasan']);
            $table->string('metode_pembayaran');
            $table->decimal('jumlah_bayar', 10,0,);
            $table->string('bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
