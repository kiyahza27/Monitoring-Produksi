<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    const SUMBER_REKBCA = 'Rekening BCA';

    const SUMBER_REKMANDIRI = 'Rekening Mandiri';

    const SUMBER_TUNAI = 'Tunai';

    const SUMBER=[
        self::SUMBER_REKBCA => 'Rekening BCA',
        self::SUMBER_REKMANDIRI => 'Rekening Mandiri',
        self::SUMBER_TUNAI => 'Tunai',
    ];

    protected $fillable = [
        'keperluan', 'keterangan', 'jumlahpengeluaran', 'sumberpengeluaran', 'buktipengeluaran'
    ];

}
