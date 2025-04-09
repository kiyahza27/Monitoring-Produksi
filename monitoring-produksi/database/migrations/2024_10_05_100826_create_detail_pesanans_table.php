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
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id')->nullable();
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onUpdate('cascade')->onDelete('cascade');
            $table->string('model');
            $table->string('jenis_bahan');
            $table->string('ukuran');
            $table->unsignedBigInteger('qty');
            $table->decimal('harga', 10, 2);
            $table->longText('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
