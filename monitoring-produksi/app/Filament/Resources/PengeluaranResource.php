<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Pengeluaran;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use function Filament\Support\format_money;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PengeluaranResource\Pages;
use App\Filament\Resources\PengeluaranResource\RelationManagers;

class PengeluaranResource extends Resource
{
    protected static ?string $model = Pengeluaran::class;

    protected static ?string $pluralModelLabel = 'Pengeluaran';

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('keperluan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('keterangan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jumlahpengeluaran')
                            ->required()
                            ->prefix('Rp')
                            ->label('Jumlah'),
                        Forms\Components\Select::make('sumberpengeluaran')
                            ->required()
                            ->label('Sumber Pengeluaran')
                            ->options(Pengeluaran::SUMBER)
                            ->native('0'),
                        Forms\Components\FileUpload::make('buktipengeluaran')
                            ->columnSpanFull()
                            ->label('Bukti Pengeluaran')
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
                Tables\Columns\TextColumn::make('keperluan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->label('Tanggal'),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlahpengeluaran')
                    ->searchable()
                    ->label('Jumlah')
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
                Tables\Columns\TextColumn::make('sumberpengeluaran')
                    ->searchable()
                    ->label('Sumber Pengeluaran'),
                Tables\Columns\ImageColumn::make('buktipengeluaran')
                    ->label('Bukti')
                    ->size(50),
                
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPengeluarans::route('/'),
            'create' => Pages\CreatePengeluaran::route('/create'),
            'edit' => Pages\EditPengeluaran::route('/{record}/edit'),
        ];
    }    
}
