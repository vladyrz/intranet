<?php

namespace App\Filament\Ops\Resources;

use App\Filament\Ops\Resources\FinancialControlResource\Pages;
use App\Filament\Resources\FinancialControlResource\RelationManagers;
use App\Models\FinancialControl;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinancialControlResource extends Resource
{
    protected static ?string $model = FinancialControl::class;

    protected static ?string $navigationGroup = null;
    protected static ?string $modelLabel = 'adelanto e inversión';
    protected static ?string $pluralModelLabel = 'adelantos e inversiones';

    public static function getNavigationGroup(): ?string
    {
        return __('resources.employee_checklist.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(12)
                    ->schema([
                        Select::make('country_id')->label('País')->relationship(name: 'country', titleAttribute: 'name')->searchable()->preload()->required()->columnSpan(3),
                        Select::make('user_id')->label('Propietario / Acreedor')->relationship(name: 'user', titleAttribute: 'name')->searchable()->preload()->required()->columnSpan(3),
                        Select::make('status')->label('Estado')->options([
                            'active' => 'Vigente',
                            'cancelled' => 'Cancelado',
                        ])->required()->columnSpan(3)->default('active'),
                        Select::make('type')->label('Tipo')->options([
                            'loan' => 'Préstamo',
                            'invoice_advance' => 'Adelanto de facturas',
                            'investment' => 'Inversión',
                        ])->reactive()->required()->columnSpan(3),
                        Select::make('currency')->label('Moneda')->options([
                            'usd' => 'USD',
                            'crc' => 'CRC',
                        ])->required()->columnSpan(3)->default('usd'),
                        TextInput::make('amount')->label('Monto')->numeric()->minValue(0)->default(0)->columnSpan(3),
                        TextInput::make('debtor')->label('Deudor')->columnSpan(3)->visible(fn(Get $get) => $get('type') === 'loan'),
                        TextInput::make('invoice_number')->label('Número de factura')->columnSpan(3)->visible(fn(Get $get) => $get('type') === 'invoice_advance'),
                        TextInput::make('responsible_person')->label('Responsable')->columnSpan(3)->visible(fn(Get $get) => $get('type') === 'invoice_advance'),
                        TextInput::make('description')->label('Descripción')->columnSpan(4),
                        DatePicker::make('entry_date')->label('Fecha de ingreso')->columnSpan(4)->native(false),
                        Textarea::make('observations')->label('Observaciones')->columnSpan(4)->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('country.name')->label('País')->searchable()->toggleable(),
                TextColumn::make('user.name')->label('Propietario / Acreedor')->searchable(),
                TextColumn::make('status')->label('Estado')->formatStateUsing(fn($state) => match ($state) {
                    'active' => 'Vigente',
                    'cancelled' => 'Cancelado',
                })->badge()->color(fn(string $state): string => match ($state) {
                    'active' => 'success',
                    'cancelled' => 'danger',
                })->alignCenter(),
                TextColumn::make('type')->label('Tipo')->formatStateUsing(fn($state) => match ($state) {
                    'loan' => 'Préstamo',
                    'invoice_advance' => 'Adelanto de facturas',
                    'investment' => 'Inversión',
                })->badge()->color(fn(string $state): string => match ($state) {
                    'loan' => 'success',
                    'invoice_advance' => 'info',
                    'investment' => 'warning',
                })->alignCenter(),
                TextColumn::make('currency')->label('Moneda')->formatStateUsing(fn($state) => match ($state) {
                    'usd' => 'USD',
                    'crc' => 'CRC',
                })->badge()->color(fn(string $state): string => match ($state) {
                    'usd' => 'info',
                    'crc' => 'danger',
                })->alignCenter(),
                TextColumn::make('amount')->label('Monto')->numeric()->alignRight(),
                TextColumn::make('entry_date')->label('Fecha de ingreso')->date()->alignCenter(),
                TextColumn::make('created_at')->label('Creado')->dateTime()->since()->alignCenter()->toggleable(),
                TextColumn::make('updated_at')->label('Actualizado')->dateTime()->since()->alignCenter()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('country_id')->label('País')->relationship(name: 'country', titleAttribute: 'name'),
                SelectFilter::make('status')->label('Estado')->options([
                    'active' => 'Vigente',
                    'cancelled' => 'Cancelado',
                ]),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\MovementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinancialControls::route('/'),
            'create' => Pages\CreateFinancialControl::route('/create'),
            'edit' => Pages\EditFinancialControl::route('/{record}/edit'),
        ];
    }
}
