<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produksi extends Model
{
    use HasFactory;

    const STATUSPD_DIPROSES = 'Diproses';

    const STATUSPD_DIKERJAKAN = 'Dikerjakan';

    const STATUSPD_SELESAI = 'Selesai';

    const STATUSPD=[
        self::STATUSPD_DIPROSES => 'Diproses',
        self::STATUSPD_DIKERJAKAN => 'Dikerjakan',
        self::STATUSPD_SELESAI => 'Selesai',
    ];
    protected $fillable = [
        'pesanan_id', 'detailpesanan_id','no_produksi', 'detail', 'bahan', 'ukuran', 'qty', 'catatan', 'status_produksi', 'tgl_mulai', 'tgl_selesai'
    ];

    public function pesanan():BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function progres(): HasMany
    {
        return $this->hasMany(ProgresProduksi::class);
    }

    public function detailpesanan():BelongsTo
    {
        return $this->belongsTo(DetailPesanan::class);
    }

    public function kategoriproduk():BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class, 'kategoriproduk_id');
    }
}
