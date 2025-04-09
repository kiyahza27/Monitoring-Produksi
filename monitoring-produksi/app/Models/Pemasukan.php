<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemasukan extends Model
{
    use HasFactory;

    const METODE_TFBCA = 'BCA - 3690123761';

    const METODE_TFMANDIRI = 'Mandiri - 0060010707507';

    const METODE_TUNAI = 'Tunai';

    const METODE=[
        self::METODE_TFBCA => 'BCA - 3690123761',
        self::METODE_TFMANDIRI => 'Mandiri - 0060010707507',
        self::METODE_TUNAI => 'Tunai',
    ];

    protected $fillable = [
        'pesanan_id', 'nama_pelanggan', 'jenis_pembayaran', 'metode_pembayaran', 'jumlah_bayar', 'bukti'
    ];

    public function pesanan():BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

}
