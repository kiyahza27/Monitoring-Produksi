<?php

namespace App\Filament\Resources\PesananResource\Pages;

use App\Filament\Resources\PesananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPesanan extends EditRecord
{
    protected static string $resource = PesananResource::class;

    protected function afterSave(): void
    {
        // Mengambil state dari form
        $state = $this->form->getState(); // Menggunakan $this->form untuk mendapatkan state

        // Menghitung total harga
        $totalHarga = $this->calculateTotal($state['produk'] ?? []);

        // Menyimpan total harga ke dalam model
        $this->record->total_harga = $totalHarga;
        $this->record->save();
    }

    private function calculateTotal($items)
    {
        return collect($items)->sum(function ($item) {
            return ($item['qty'] ?? 0) * ($item['harga'] ?? 0);
        });
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}
