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
        Schema::create('progres_produksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produksi_id')->nullable();
            $table->foreign('produksi_id')->references('id')->on('produksis')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_karyawan');
            $table->string('status');
            $table->string('upah_produksi');
            $table->string('produk_cacat');
            $table->string('total_upah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_produksis');
    }
};
