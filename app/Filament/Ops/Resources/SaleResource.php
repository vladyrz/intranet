<?php

namespace App\Filament\Ops\Resources;

use App\Filament\Ops\Resources\SaleResource\Pages;
use App\Filament\Ops\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.sales.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.sales.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.sales.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.sales.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.sale.sectionSale'))
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('property_name')
                        ->label(__('translate.sale.property_name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('user_id')
                        ->relationship(
                            name: 'user',
                            titleAttribute: 'name',
                        )
                        ->label(__('translate.sale.user_id'))
                        ->required(),
                    Forms\Components\Select::make('organization_id')
                        ->relationship(
                            name: 'organization',
                            titleAttribute: 'organization_name',
                        )
                        ->label(__('translate.sale.organization_id'))
                        ->required(),
                    Forms\Components\TextInput::make('offer_amount_usd')
                        ->label(__('translate.sale.offer_amount_usd'))
                        ->numeric(),
                    Forms\Components\TextInput::make('offer_amount_crc')
                        ->label(__('translate.sale.offer_amount_crc'))
                        ->numeric(),
                    Forms\Components\Select::make('status')
                        ->label(__('translate.sale.status'))
                        ->options([
                            'offered' => __('translate.sale.options_status.0'),
                            'in_process' => __('translate.sale.options_status.1'),
                            'approved' => __('translate.sale.options_status.2'),
                            'signed' => __('translate.sale.options_status.3'),
                            'rejected' => __('translate.sale.options_status.4'),
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('client_name')
                        ->label(__('translate.sale.client_name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('client_email')
                        ->label(__('translate.sale.client_email'))
                        ->email()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('offer_date')
                        ->label(__('translate.sale.offer_date'))
                        ->required(),
                    Forms\Components\Select::make('comission_percentage')
                        ->label(__('translate.sale.comission_percentage'))
                        ->options([
                            '6%' => '6%',
                            '5%' => '5%',
                            '4%' => '4%',
                            '3%' => '3%',
                            '2%' => '2%',
                            '1%' => '1%',
                        ])
                        ->required(),
                    Forms\Components\Select::make('offer_currency')
                        ->label(__('translate.sale.offer_currency'))
                        ->options([
                            'usd' => __('translate.sale.options_currency.0'),
                            'crc' => __('translate.sale.options_currency.1'),
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('commission_amount_usd')
                        ->label(__('translate.sale.commission_amount_usd'))
                        ->numeric(),
                    Forms\Components\TextInput::make('commission_amount_crc')
                        ->label(__('translate.sale.commission_amount_crc'))
                        ->numeric(),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property_name')
                    ->label(__('translate.sale.property_name'))
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('translate.sale.user_id'))
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('organization.organization_name')
                    ->label(__('translate.sale.organization_id'))
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('offer_amount_usd')
                    ->label(__('translate.sale.offer_amount_usd'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('offer_amount_crc')
                    ->label(__('translate.sale.offer_amount_crc'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('translate.sale.status'))
                    ->alignCenter()
                    ->searchable()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'offered' => __('translate.sale.options_status.0'),
                            'in_process' => __('translate.sale.options_status.1'),
                            'approved' => __('translate.sale.options_status.2'),
                            'signed' => __('translate.sale.options_status.3'),
                            'rejected' => __('translate.sale.options_status.4'),
                        };
                    }),
                Tables\Columns\TextColumn::make('client_name')
                    ->label(__('translate.sale.client_name'))
                    ->alignCenter()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('client_email')
                    ->label(__('translate.sale.client_email'))
                    ->alignCenter()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('offer_date')
                    ->label(__('translate.sale.offer_date'))
                    ->alignCenter()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('comission_percentage')
                    ->label(__('translate.sale.comission_percentage'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('offer_currency')
                    ->label(__('translate.sale.offer_currency'))
                    ->alignCenter()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'usd' => __('translate.sale.options_currency.0'),
                            'crc' => __('translate.sale.options_currency.1'),
                        };
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('commission_amount_usd')
                    ->label(__('translate.sale.commission_amount_usd'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('commission_amount_crc')
                    ->label(__('translate.sale.commission_amount_crc'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('translate.sale.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('translate.sale.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
