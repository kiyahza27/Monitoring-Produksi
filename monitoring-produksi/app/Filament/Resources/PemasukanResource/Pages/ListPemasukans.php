<?php

namespace App\Filament\Resources\PemasukanResource\Pages;

use App\Filament\Resources\PemasukanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListPemasukans extends ListRecords
{
    protected static string $resource = PemasukanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make() 
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                        // ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        // ->withColumns([
                        //     Column::make('updated_at'),
                        // ])
                ]), 
        ];
    }
}
