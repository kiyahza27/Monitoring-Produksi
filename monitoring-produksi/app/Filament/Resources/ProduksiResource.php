<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Livewire\Livewire;
use App\Models\Pesanan;
use Filament\Forms\Set;
use App\Models\Karyawan;
use App\Models\Produksi;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DetailPesanan;
use App\Models\KategoriProduk;
use App\Models\ProgresProduksi;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProduksiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProduksiResource\RelationManagers;
use Illuminate\Support\Facades\DB;

class ProduksiResource extends Resource
{
    protected static ?string $model = Produksi::class;

    protected static ?string $pluralModelLabel = 'Proses Produksi';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                TextInput::make('no_produksi')
                                    ->label('Nomor Produksi')
                                    ->default('PRDK-')
                                    ->required()
                                    ->unique(ignorable:fn($record)=>$record),
                                Select::make('pesanan_id')
                                    ->label('Nomor Pesanan')
                                    ->native('0')
                                    // ->reactive()
                                    ->live()
                                    ->options(Pesanan::pluck('nomor_pesanan', 'id'))
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('detailpesanan_id', null);
                                        $set('detail', null);
                                        $set('bahan', null);
                                        $set('ukuran', null);
                                        $set('qty', null);
                                        $set('catatan', null);
                                    })
                                    ->required(),
                                Select::make('detailpesanan_id')
                                    ->label('kode produk')
                                    ->options(function (Forms\Get $get) {
                                        // Ambil pesanan_id dari input
                                        $pesananId = $get('pesanan_id');
                                    
                                        // Ambil detail pesanan berdasarkan pesanan_id
                                        // Lakukan join dengan KategoriProduk untuk mendapatkan deskripsi
                                        return DetailPesanan::where('pesanan_id', $pesananId)
                                            ->whereNotIn('detail_pesanans.id', function ($query) {
                                                $query->select('detail_pesanans.id')
                                                    ->from('detail_pesanans')
                                                    ->join('produksis', 'detail_pesanans.id', '=', 'produksis.detailpesanan_id');
                                            }) //memberikan batasan antara status produksi yg belum selesai dan yg sudah selesai
                                            ->join('kategori_produks', 'detail_pesanans.kategoriproduk_id', '=', 'kategori_produks.id')
                                            ->pluck('kategori_produks.kode_produk', 'detail_pesanans.id');
                                    })
                                    ->native('0')
                                    // ->options(function (Forms\Get $get) {
                                    //     return DetailPesanan::where('pesanan_id', $get('pesanan_id'))->pluck('kategoriproduk_id', 'id');
                                    // })

                                    ->afterStateUpdated(function (Set $set, $state) {
                                        // Jika state kosong, set semua nilai terkait menjadi null
                                        if (empty($state)) {
                                            $set('detail', null);
                                            $set('bahan', null);
                                            $set('ukuran', null);
                                            $set('qty', null);
                                            $set('catatan', null);
                                            return; // Keluar dari fungsi jika state kosong
                                        }
                                
                                        // Jika state tidak kosong, cari detail pesanan berdasarkan state
                                        $detailpesanan = DetailPesanan::find($state);
                                        if ($detailpesanan) {
                                            // Ambil deskripsi berupa kode_produk dari relasi Kategoriproduk
                                            $deskripsi = $detailpesanan->kategoriproduk->kode_produk;
                                
                                            // Set nilai ke 'detail' dengan deskripsi
                                            $set('detail', $deskripsi);
                                            $set('bahan', $detailpesanan->jenis_bahan);
                                            $set('ukuran', $detailpesanan->ukuran);
                                            $set('qty', $detailpesanan->qty);
                                            $set('catatan', $detailpesanan->catatan);
                                        } else {
                                            // Jika tidak ditemukan, set nilai ke null atau nilai default lainnya
                                            $set('detail', null);
                                            $set('bahan', null);
                                            $set('ukuran', null);
                                            $set('qty', null);
                                            $set('catatan', null);
                                        }
                                    })
                                    // ->disabled(fn(Forms\Get $get) : bool => ! filled($get('pesanan_id')))
                                    ->reactive()
                                    ->live()
                                    ->required(),
                                TextInput::make('detail')
                                    // ->disabled()
                                    ->required(),
                                TextInput::make('bahan')
                                    // ->disabled()
                                    ->required(),
                                TextInput::make('ukuran')
                                    // ->disabled()
                                    ->required(),
                                TextInput::make('qty')
                                    // ->disabled()    
                                    ->required(),
                                Select::make('status_produksi')
                                    ->required()
                                    ->label('Status')
                                    ->options(Produksi::STATUSPD)
                                    ->native('0'),
                                TextInput::make('catatan')
                                    ->label('Catatan'),
                                DatePicker::make('tgl_mulai')
                                    ->label('Tgl Mulai')
                                    ->required(),
                                DatePicker::make('tgl_selesai')
                                    ->label('Tgl Selesai'),
                            ])
                            ->columns(2),
                        
                        Card::make()
                            ->schema([
                                Repeater::make('progres')
                                    ->relationship()
                                    ->schema([
                                        Select::make('karyawan_id')
                                            ->label('Pekerjaan')
                                            ->placeholder('Pekerjaan')
                                            ->options(Karyawan::query()->pluck('pekerjaan', 'id'))
                                            ->reactive()
                                            ->native('0')
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('nama_karyawan', Karyawan::find($state)?->namakaryawan ?? 0))
                                            ->required(),
                                        TextInput::make('nama_karyawan')
                                            ->label('Nama')
                                            ->placeholder('Nama')
                                            ->disabled()
                                            ->dehydrated()
                                            ->required(),
                                        Select::make('status')
                                            ->required()
                                            ->label('Status')
                                            ->placeholder('Status')
                                            ->options(ProgresProduksi::STATUS)
                                            ->native('0'),
                                        TextInput::make('upah_produksi')
                                            ->label('Upah (/pcs)')
                                            ->prefix('Rp')
                                            ->required(),
                                        TextInput::make('produk_cacat')
                                            ->numeric(),
                                        TextInput::make('total_upah')
                                            ->label('Total Upah')
                                            ->prefix('Rp'),
                                            
                                    ])

                                    ->defaultItems(1) 
                                    ->columns(['md' => 6,])
                                    ->columnSpan('full')
                            ]),

                    ])->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_produksi')
                    ->label('No. Produksi')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('pesanan.nomor_pesanan')
                    ->label('No. Pesanan')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                
                TextColumn::make('detail')
                    ->label('Detail')
                    ->searchable(),
            
                TextColumn::make('bahan')
                    ->label('Bahan')
                    ->searchable(),
                
                TextColumn::make('ukuran')
                    ->label('Ukuran')
                    ->searchable(),
                
                TextColumn::make('qty')
                    ->label('Qty')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status_produksi')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Diproses' => 'warning',
                        'Dikerjakan' => 'info',
                        'Selesai' => 'success',
                    })
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('catatan')
                    ->label('Catatan')
                    ->searchable(),

                TextColumn::make('tgl_mulai')
                    ->label('Tgl Mulai')
                    ->sortable()
                    ->searchable()
                    ->date(),
                TextColumn::make('tgl_selesai')
                    ->label('Tgl Selesai')
                    ->sortable()
                    ->searchable()
                    ->date(),
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
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListProduksis::route('/'),
            'create' => Pages\CreateProduksi::route('/create'),
            'edit' => Pages\EditProduksi::route('/{record}/edit'),
        ];
    }    
}
