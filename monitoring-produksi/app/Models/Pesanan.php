<?php

namespace App\Models;

use Filament\Forms\Components\HasManyRepeater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pelanggan_id', 'nomor_pesanan', 'tgl_pesanan', 'total_harga', 'status_pesanan', 'status_pembayaran', 'desain'
    ];

    public function pelanggan():BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function produk(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }

}
