<?php

namespace App\Filament\Resources\ExpenseControlResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';
    protected static ?string $title = 'Pagos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('currency')
                    ->options(\App\Enums\ExpenseCurrency::class)
                    ->default(fn($livewire) => $livewire->getOwnerRecord()->currency)
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix(fn($livewire) => $livewire->getOwnerRecord()->currency->name)
                    ->default(fn($livewire) => $livewire->getOwnerRecord()->amount),

                Forms\Components\Select::make('status')
                    ->options(\App\Enums\ExpensePaymentStatus::class)
                    ->default(\App\Enums\ExpensePaymentStatus::Paid)
                    ->required(),

                Forms\Components\DateTimePicker::make('paid_at')
                    ->default(now())
                    ->required()
                    ->native(false),

                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => auth()->id())
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('amount')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Registrado por')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->money(fn($record) => $record->currency->name)
                    ->sortable()
                    ->label('Monto'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Estado'),

                Tables\Columns\TextColumn::make('paid_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Fecha de pago'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Agregar pago'),
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
