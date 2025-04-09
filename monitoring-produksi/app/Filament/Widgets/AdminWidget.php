<?php

namespace App\Filament\Widgets;

use App\Models\Pelanggan;
use App\Models\Pemasukan;
use App\Models\DetailPesanan;
use App\Models\User;
use Illuminate\Support\Str;
use function Filament\Support\format_money;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class AdminWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('DetailPesanan', DetailPesanan::sum('qty'))
                ->description('Total Pesanan Masuk')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info'),
            Stat::make('Pelanggan', Pelanggan::count())
                ->description('Total Pelanggan')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
            Stat::make('Pemasukan', $this->formatToIDR(Pemasukan::sum('jumlah_bayar')))
                ->description('Total Pemasukan')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Users', User::count())
                ->description('User')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('purple'),
        ];
    }

    protected function formatToIDR($amount)
    {
        // Menggunakan NumberFormatter untuk format IDR
        $formatter = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, 'IDR');
    }

    // public function goto()
    // {
    //     return redirect()->to('admin/pelanggans');
    // }

    // protected static bool $isLazy = false;  //Disabling lazy loading

    public static function canView():bool{
        return auth()->user()->isAdmin();
    }

}
