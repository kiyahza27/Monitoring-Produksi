<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pesanan;
use Filament\Forms\Form;
use App\Models\Pelanggan;
use App\Models\Pemasukan;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use function Filament\Support\format_money;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\PemasukanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PemasukanResource\RelationManagers;

class PemasukanResource extends Resource
{
    protected static ?string $model = Pemasukan::class;

    protected static ?string $pluralModelLabel = 'Pemasukan';

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        // Select::make('pelanggan_id')
                        //     ->label('Nomor Pesanan')
                        //     ->placeholder('Pilih nomor pesanan')
                        //     // ->searchable()
                        //     // ->relationship('pesanan', 'nomor_pesanan')
                        //     // ->options(Pesanan::query()->pluck('nomor_pesanan', 'pelanggan_id'))
                        //     // ->reactive()
                        //     // ->native('0')
                        //     // ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('nama_pelanggan', Pelanggan::find($state)?->nama ?? 0))
                        //     ->required(),
                        Select::make('pesanan_id')
                            ->label('Pilih Nomor Pesanan')
                            ->placeholder('Pilih nomor pesanan')
                            ->relationship('pesanan', 'nomor_pesanan')
                            ->options(Pesanan::query()->pluck('nomor_pesanan', 'pelanggan_id'))
                            ->reactive()
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('nama_pelanggan', Pelanggan::find($state)?->nama ?? 0))
                            ->native('0')
                            ->required(),
                        TextInput::make('nama_pelanggan')
                            ->label('Nama Pelanggan')
                            ->placeholder('Nama Pelanggan')
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Select::make('jenis_pembayaran')
                            ->label('Jenis Pembayaran')
                            ->placeholder('Pilih jenis pembayaran')
                            ->native('0') // select option dropdown theme 
                            ->options([
                                'DP'=>'DP', 
                                'Pelunasan'=>'Pelunasan'
                            ])
                            ->required(),
                        Select::make('metode_pembayaran')
                            ->label('Metode Pembayaran')
                            ->placeholder('Pilih metode pembayaran')
                            ->native('0') // select option dropdown theme 
                            ->options([
                                'BCA - 3690123761'=>'BCA - 3690123761', 
                                'Mandiri - 0060010707507'=>'Mandiri - 0060010707507', 
                                'Lainnya'=>'Lainnya'
                            ])
                            ->required(),
                        TextInput::make('jumlah_bayar')
                            ->label('Jumlah')
                            ->prefix('Rp')
                            // ->columnSpanFull()
                            ->required(),
                        FileUpload::make('bukti')
                            ->columnSpanFull()
                            ->image()
                            ->imageEditor(),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pesanan.nomor_pesanan')
                    ->label('Nomor Pesanan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nama_pelanggan')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->sortable()
                    ->date(),

                TextColumn::make('jenis_pembayaran')
                    ->label('Jenis')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'DP' => 'info',
                        'Pelunasan' => 'success',
                    })
                    ->searchable(),

                TextColumn::make('metode_pembayaran')
                    ->label('Metode Bayar')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('jumlah_bayar')
                    ->label('Total')
                    ->sortable()
                    ->searchable()
                    ->money('IDR')
                    ->formatStateUsing(function ($state){
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })
                    ->summarize([
                        Sum::make()
                        ->label('Total')
                        ->money()
                        ->formatStateUsing(function ($state){
                            return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                        })
                    ]),
                
                ImageColumn::make('bukti')
                    ->label('bukti')
                    ->size(50),

            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('mulai_tanggal'),
                        DatePicker::make('sampai_tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['mulai_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPemasukans::route('/'),
            'create' => Pages\CreatePemasukan::route('/create'),
            'edit' => Pages\EditPemasukan::route('/{record}/edit'),
        ];
    }    
}
