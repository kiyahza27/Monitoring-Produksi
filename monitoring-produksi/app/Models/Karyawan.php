<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    const PEKERJAAN_MEMOTONG = 'Memotong';

    const PEKERJAAN_MENJAHIT = 'Menjahit';

    const PEKERJAAN_MEMBORDIR = 'Membordir';

    const PEKERJAAN_AKSESORIS = 'Memasang Aksesoris';

    const PEKERJAAN=[
        self::PEKERJAAN_MEMOTONG => 'Memotong',
        self::PEKERJAAN_MENJAHIT => 'Menjahit',
        self::PEKERJAAN_MEMBORDIR => 'Membordir',
        self::PEKERJAAN_AKSESORIS => 'Memasang Aksesoris',
    ];

    protected $fillable = [
        'namakaryawan', 'nomorhpkaryawan', 'pekerjaan', 'alamatkaryawan'
    ];
}
