<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgresProduksi extends Model
{
    use HasFactory;

    const STATUS_DIPROSES = 'Diproses';

    const STATUS_DIKERJAKAN = 'Dikerjakan';

    const STATUS_SELESAI = 'Selesai';

    const STATUS=[
        self::STATUS_DIPROSES => 'Diproses',
        self::STATUS_DIKERJAKAN => 'Dikerjakan',
        self::STATUS_SELESAI => 'Selesai',
    ];

    protected $fillable = [
        'karyawan_id', 'nama_karyawan', 'status', 'upah_produksi', 'produk_cacat', 'total_upah'
    ];

    public function karyawan():BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }


}
