<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\KategoriProduk;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KategoriProdukResource\Pages;
use App\Filament\Resources\KategoriProdukResource\RelationManagers;

class KategoriProdukResource extends Resource
{
    protected static ?string $model = KategoriProduk::class;

    protected static ?string $pluralModelLabel = 'Kategori Produk';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('kode_produk')
                            ->required()
                            ->label('Kode Produk')
                            ->unique(ignorable:fn($record)=>$record),
                        TextInput::make('model_produk')
                            ->label('Model Produk')
                            ->required(),
                        // Select::make('variasi')
                        //     ->native('0')
                        //     ->options([
                        //         'Dewasa' => 'Dewasa',
                        //         'Anak-anak' => 'Anak-anak',
                        //     ])
                        //     ->required(),
                        TextInput::make('deskripsi_produk')
                            ->label('Deskripsi Produk')
                            ->required(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_produk')
                    ->label('Kode Produk')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('model_produk')
                    ->label('Model Produk')
                    ->sortable()
                    ->searchable(),

                // TextColumn::make('variasi')
                //     ->sortable()
                //     ->searchable(),

                TextColumn::make('deskripsi_produk')
                    ->label('Deskripsi Produk')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListKategoriProduks::route('/'),
            'create' => Pages\CreateKategoriProduk::route('/create'),
            'edit' => Pages\EditKategoriProduk::route('/{record}/edit'),
        ];
    }    
}
