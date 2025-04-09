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
        Schema::create('produksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id')->nullable();
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onUpdate('cascade')->onDelete('cascade');
            $table->string('no_produksi')->unique();
            $table->string('detail');
            $table->string('ukuran');
            $table->unsignedBigInteger('qty');
            $table->string('status_produksi');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};
