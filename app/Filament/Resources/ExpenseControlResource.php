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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExpenseControlResource extends Resource
{
    protected static ?string $model = ExpenseControl::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $modelLabel = 'control de gasto';
    protected static ?string $pluralModelLabel = 'control de gastos';
    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('resources.employee_checklist.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información General')
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->relationship('country', 'name')
                            ->required()
                            ->label('País'),

                        Forms\Components\Select::make('area')
                            ->options(ExpenseArea::class)
                            ->required()
                            ->enum(ExpenseArea::class),

                        Forms\Components\Select::make('status')
                            ->options(ExpenseStatus::class)
                            ->required()
                            ->default(ExpenseStatus::Active)
                            ->enum(ExpenseStatus::class)
                            ->label('Estado'),
                    ])->columns(3),

                Forms\Components\Section::make('Detalles financieros')
                    ->schema([
                        Forms\Components\Select::make('cost_type')
                            ->label('Tipo de costo / Frecuencia')
                            ->options(ExpenseCostType::class)
                            ->required()
                            ->enum(ExpenseCostType::class)
                            ->live(),

                        Forms\Components\DatePicker::make('payment_date')
                            ->label(fn(Forms\Get $get) => match ($get('cost_type')) {
                                ExpenseCostType::OneTime->value => 'Fecha de pago',
                                default => 'Fecha de primer pago',
                            })
                            ->required()
                            ->default(now()->addDay()->startOfDay())
                            ->native(false),

                        Forms\Components\Select::make('currency')
                            ->options(ExpenseCurrency::class)
                            ->required()
                            ->enum(ExpenseCurrency::class)
                            ->default(ExpenseCurrency::CRC)
                            ->reactive()
                            ->label('Moneda'),

                        Forms\Components\TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->prefix(fn(Forms\Get $get) => match ($get('currency')) {
                                ExpenseCurrency::USD->value => '$',
                                default => '₡',
                            })
                            ->label('Monto'),
                    ])->columns(2),

                Forms\Components\Section::make('Descripción')
                    ->schema([
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->label('Descripción'),

                        Forms\Components\Textarea::make('details')
                            ->columnSpanFull()
                            ->rows(3)
                            ->label('Detalles'),
                    ]),

                Forms\Components\Section::make('Estado del sistema')
                    ->schema([
                        Forms\Components\Placeholder::make('next_run_at')
                            ->content(fn(?ExpenseControl $record) => $record?->next_run_at?->format('d/m/Y h:i A') ?? 'Pendiente')
                            ->label('Proximo recordatorio'),

                        Forms\Components\Placeholder::make('last_sent_at')
                            ->content(fn(?ExpenseControl $record) => $record?->last_sent_at?->format('d/m/Y h:i A') ?? 'Nunca')
                            ->label('Ultimo recordatorio'),

                        Forms\Components\Placeholder::make('failure_count')
                            ->content(fn(?ExpenseControl $record) => $record?->failure_count ?? 0)
                            ->visible(fn(?ExpenseControl $record) => $record?->failure_count > 0)
                            ->label('Intentos fallidos'),
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
                    ->searchable()
                    ->label('País'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Estado'),

                Tables\Columns\TextColumn::make('cost_type')
                    ->label('Tipo de costo')
                    ->sortable(),

                Tables\Columns\TextColumn::make('area')
                    ->sortable()
                    ->badge()
                    ->label('Área'),

                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Fecha de pago')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('next_run_at')
                    ->label('Proximo recordatorio')
                    ->dateTime('d/m/Y h:i A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Monto')
                    ->money(fn(ExpenseControl $record) => $record->currency === ExpenseCurrency::USD ? 'USD' : 'CRC')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options(ExpenseStatus::class),
                Tables\Filters\SelectFilter::make('area')
                    ->label('Área')
                    ->options(ExpenseArea::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\PaymentsRelationManager::class,
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
