<?php

namespace App\Filament\Widgets;

use App\Models\Karyawan;
use App\Models\DetailPesanan;
use App\Models\Produksi;
use App\Models\Pengeluaran;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProduksiWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('DetailPesanan', DetailPesanan::sum('qty'))
                ->description('Total Pesanan Masuk')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info'),
            Stat::make('Produksi', Produksi::sum('qty'))
                ->description('Jumlah Produksi')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
            Stat::make('Data Karyawan', Karyawan::count())
                ->description('Jumlah Karyawan')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('purple'),
            Stat::make('Pengeluaran', $this->formatToIDR(Pengeluaran::sum('jumlahpengeluaran')))
                ->description('Total Pengeluaran')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
        ];
    }

    protected function formatToIDR($amount)
    {
        // Menggunakan NumberFormatter untuk format IDR
        $formatter = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, 'IDR');
    }

    public static function canView():bool{
        return auth()->user()->isProduksi();
    }
}
