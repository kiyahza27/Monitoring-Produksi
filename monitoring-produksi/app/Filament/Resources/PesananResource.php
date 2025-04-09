<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pesanan;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\DetailPesanan;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use function Filament\Support\format_money;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\PesananResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\PesananResource\RelationManagers;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $pluralModelLabel = 'Pesanan';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                TextInput::make('nomor_pesanan')
                                    ->label('Nomor Pesanan')
                                    ->default('PO-')
                                    ->length(9)
                                    ->minLength(9)
                                    ->required()
                                    ->unique(ignorable: fn($record) => $record),
                                Select::make('pelanggan_id')
                                    ->label('Nama Pelanggan')
                                    ->relationship('pelanggan', 'nama')
                                    ->searchable()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('nama')
                                            ->required(),
                                        TextInput::make('email')
                                            ->required()
                                            ->email()
                                            ->unique(ignorable: fn($record) => $record),
                                        TextInput::make('nomorhp')
                                            ->label('Nomor HP')
                                            ->maxValue(20),
                                        TextInput::make('alamat')
                                            ->required(),
                                    ])
                                    ->createOptionAction(function (Action $action) {
                                        return $action
                                            ->modalHeading('Create pelanggan')
                                            ->modalSubmitActionLabel('Create pelanggan')
                                            ->modalWidth('lg');
                                    }),

                                DatePicker::make('tgl_pesanan')
                                    ->label('Tanggal Pesanan')
                                    ->required(),
                                Select::make('status_pesanan')
                                    ->label('Status Pesanan')
                                    ->default('Baru')
                                    ->native('0') // select option dropdown theme 
                                    ->options([
                                        'Baru' => 'Baru',
                                        'Diproses' => 'Diproses',
                                        'Diambil' => 'Diambil',
                                        'Dikirim' => 'Dikirim',
                                        'Selesai' => 'Selesai'
                                    ])
                                    ->required(),
                                Select::make('status_pembayaran')
                                    ->label('Status Pembayaran')
                                    ->placeholder('Pilih status pembayaran')
                                    ->native('0') // select option dropdown theme 
                                    ->options([
                                        'Belum Bayar' => 'Belum Bayar',
                                        'DP' => 'DP',
                                        'Lunas' => 'Lunas'
                                    ])
                                    ->required(),

                                TextInput::make('total_harga')
                                    ->label('Total Harga')
                                    ->disabled()
                                    ->default(0),
                                
                                FileUpload::make('desain')
                                    ->label('Permintaan Desain')
                                    ->columnSpanFull()
                                    ->image()
                                    ->imageEditor(),
                            ])
                            ->columns(2),

                        Card::make()
                            ->schema([
                                Repeater::make('produk')
                                    ->relationship()
                                    ->schema([
                                        Select::make('kategoriproduk_id')
                                            ->label('Kode Produk')
                                            ->placeholder('kode produk')
                                            ->relationship('kategoriproduk', 'kode_produk')
                                            ->searchable()
                                            ->required(),
                                        TextInput::make('jenis_bahan')
                                            ->required(),
                                        Select::make('ukuran')
                                            ->placeholder('Pilih Ukuran')
                                            ->native('0') // select option dropdown theme
                                            ->options([
                                                'S anak-anak' => 'S anak-anak',
                                                'M anak-anak' => 'M anak-anak',
                                                'L anak-anak' => 'L anak-anak',
                                                'XL ank-anak' => 'XL anak-anak',
                                                'S' => 'S',
                                                'M' => 'M',
                                                'L' => 'L',
                                                'XL' => 'XL',
                                                'XXL' => 'XXL',
                                                'XXXL' => 'XXXL'
                                            ])
                                            ->required(),
                                        TextInput::make('qty')
                                            ->required()
                                            // ->live(onBlur: true)
                                            ->numeric()
                                            ->reactive()
                                            // ->afterStateUpdated(fn($state, $set) => $set('total_harga', self::calculateTotal($state)))
                                            ->afterStateUpdated(fn($state, $set) => $set('total_harga', self::calculateTotal($form->getState()['produk'] ?? [])))
                                            // ->afterStateUpdated(function (Get $get, Set $set) {
                                            //     self::calculateTotals($get, $set);
                                            // })
                                            ->minValue(1),
                                        TextInput::make('harga')
                                            ->label('Harga Satuan')
                                            // ->live(onBlur: true)
                                            ->required()
                                            ->numeric()
                                            ->reactive()
                                            // ->afterStateUpdated(fn($state, $set) => $set('total_harga', self::calculateTotal($state)))
                                            ->afterStateUpdated(fn($state, $set) => $set('total_harga', self::calculateTotal($form->getState()['produk'] ?? [])))
                                            // ->afterStateUpdated(function (Get $get, Set $set): void {
                                            //     self::calculateTotals($get, $set);
                                            // })
                                            ->minValue(0),
                                        TextInput::make('catatan')
                                    ])
                                    ->defaultItems(1)
                                    ->columns(['md' => 6,])
                                    ->columnSpan('full')
                                    ->required(),
                            ]),
                    ])->columnSpan('full')

            ]);
    }

    public static function calculateTotal($items)
    {
        return collect($items)->sum(function ($item) {
            return ($item['qty'] ?? 0) * ($item['harga'] ?? 0);
        });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_pesanan')
                    ->label('Nomor Pesanan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('pelanggan.nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tgl_pesanan')
                    ->label('Tanggal')
                    ->sortable()
                    ->searchable()
                    ->date(),

                TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->sortable()
                    ->searchable()
                    ->money('IDR')
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })
                    ->summarize([
                        Sum::make()
                            ->label('Total')
                            ->money()
                            ->formatStateUsing(function ($state) {
                                return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                            })
                    ]),

                TextColumn::make('status_pesanan')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Baru' => 'info',
                        'Diproses' => 'warning',
                        'Diambil' => 'gray',
                        'Dikirim' => 'gray',
                        'Selesai' => 'success',
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->sortable()
                    ->searchable(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            // ->headerActions([
            //     ExportBulkAction::make(),
            // ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
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
            'index' => Pages\ListPesanans::route('/'),
            'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }

    public static function calculateTotals(Get $get, Set $set): void
    {
        $set('total_harga', number_format($get('qty') * $get('harga')));
    }

}
