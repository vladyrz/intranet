<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseControlResource\Pages;
use App\Filament\Resources\ExpenseControlResource\RelationManagers;
use App\Enums\ExpenseArea;
use App\Enums\ExpenseCostType;
use App\Enums\ExpenseCurrency;
use App\Enums\ExpenseStatus;
use App\Models\ExpenseControl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseControlResource extends Resource
{
    protected static ?string $model = ExpenseControl::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Information')
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->relationship('country', 'name')
                            ->searchable()
                            ->required()
                            ->label('Country'),

                        Forms\Components\Select::make('area')
                            ->options(ExpenseArea::class)
                            ->required()
                            ->enum(ExpenseArea::class),

                        Forms\Components\Select::make('status')
                            ->options(ExpenseStatus::class)
                            ->required()
                            ->default(ExpenseStatus::Active)
                            ->enum(ExpenseStatus::class),
                    ])->columns(3),

                Forms\Components\Section::make('Financial Details')
                    ->schema([
                        Forms\Components\Select::make('cost_type')
                            ->label('Cost Type / Frequency')
                            ->options(ExpenseCostType::class)
                            ->required()
                            ->enum(ExpenseCostType::class)
                            ->live(),

                        Forms\Components\DatePicker::make('payment_date')
                            ->label(fn(Forms\Get $get) => match ($get('cost_type')) {
                                ExpenseCostType::OneTime->value => 'Payment Date',
                                default => 'First Payment Date',
                            })
                            ->required()
                            ->default(now()->addDay()->startOfDay()),

                        Forms\Components\Select::make('currency')
                            ->options(ExpenseCurrency::class)
                            ->required()
                            ->enum(ExpenseCurrency::class)
                            ->default(ExpenseCurrency::CRC),

                        Forms\Components\TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->prefix(fn(Forms\Get $get) => match ($get('currency')) {
                                ExpenseCurrency::USD->value => '$',
                                default => '₡',
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('details')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),

                Forms\Components\Section::make('System Status')
                    ->schema([
                        Forms\Components\Placeholder::make('next_run_at')
                            ->content(fn(?ExpenseControl $record) => $record?->next_run_at?->format('d/m/Y h:i A') ?? 'Pending'),

                        Forms\Components\Placeholder::make('last_sent_at')
                            ->content(fn(?ExpenseControl $record) => $record?->last_sent_at?->format('d/m/Y h:i A') ?? 'Never'),

                        Forms\Components\Placeholder::make('failure_count')
                            ->content(fn(?ExpenseControl $record) => $record?->failure_count ?? 0)
                            ->visible(fn(?ExpenseControl $record) => $record?->failure_count > 0),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(fn($record) => $record === null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge(),

                Tables\Columns\TextColumn::make('cost_type')
                    ->label('Type')
                    ->sortable(),

                Tables\Columns\TextColumn::make('area')
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('payment_date')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('next_run_at')
                    ->label('Next Alert')
                    ->dateTime('d/m/Y h:i A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                    ->money(fn(ExpenseControl $record) => $record->currency === ExpenseCurrency::USD ? 'USD' : 'CRC')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(ExpenseStatus::class),
                Tables\Filters\SelectFilter::make('area')
                    ->options(ExpenseArea::class),
                Tables\Filters\SelectFilter::make('cost_type')
                    ->options(ExpenseCostType::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('next_run_at', 'asc');
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
            'index' => Pages\ListExpenseControls::route('/'),
            'create' => Pages\CreateExpenseControl::route('/create'),
            'edit' => Pages\EditExpenseControl::route('/{record}/edit'),
        ];
    }
}
