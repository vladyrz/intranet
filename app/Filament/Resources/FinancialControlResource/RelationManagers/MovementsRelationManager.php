<?php

namespace App\Filament\Resources\FinancialControlResource\RelationManagers;

use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';
    protected static ?string $title = 'Movimentos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('currency')->label('Moneda')->options([
                    'usd' => 'USD',
                    'crc' => 'CRC',
                ])->default('usd')->required(),
                TextInput::make('amount')->label('Monto')->numeric()->minValue(0)->default(0)->required(),
                DatePicker::make('movement_date')->label('Fecha')->required()->native(false),
                TextInput::make('balance')->label('Balance')->numeric()->minValue(0)->default(0)->required(),
                Textarea::make('observation')->label('Observaciones')->rows(3)->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('movement_date')
            ->columns([
                TextColumn::make('currency')->label('Moneda')->alignCenter()->formatStateUsing(function ($state) {
                    return match ($state) {
                        'usd' => 'USD',
                        'crc' => 'CRC',
                    };
                })->badge()->color(fn(string $state): string => match ($state){
                    'usd' => 'info',
                    'crc' => 'danger',
                }),
                TextColumn::make('amount')->label('Monto')->numeric()->alignRight(),
                TextColumn::make('movement_date')->label('Fecha')->date(),
                TextColumn::make('balance')->label('Balance')->numeric()->alignRight(),
                TextColumn::make('observation')->label('Observaciones')->limit(50)->toggleable(),
                TextColumn::make('created_at')->label('Creado')->dateTime()->since()->toggleable(),
                TextColumn::make('updated_at')->label('Actualizado')->dateTime()->since()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Crear movimiento'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
