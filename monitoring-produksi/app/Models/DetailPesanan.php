<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id', 'kategoriproduk_id', 'jenis_bahan', 'ukuran', 'qty', 'harga', 'catatan'
    ];

    public function pesanan():BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function kategoriproduk():BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class, 'kategoriproduk_id');
    }
}
