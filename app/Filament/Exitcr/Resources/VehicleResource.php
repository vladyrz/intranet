<?php

namespace App\Filament\Exitcr\Resources;

use App\Filament\Exitcr\Resources\VehicleResource\Pages;
use App\Filament\Exitcr\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.vehicle.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.vehicle.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.vehicle.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.vehicle.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.vehicle.sectionVehicle'))
                ->columns(2)
                ->schema([
                    TextInput::make('license_plate')
                        ->label(__('translate.vehicle.license_plate'))
                        ->required()
                        ->unique()
                        ->maxLength(15),
                    TextInput::make('brand')
                        ->label(__('translate.vehicle.brand'))
                        ->required()
                        ->maxLength(100),
                    TextInput::make('style')
                        ->label(__('translate.vehicle.style'))
                        ->required()
                        ->maxLength(100),
                    TextInput::make('year')
                        ->label(__('translate.vehicle.year'))
                        ->required()
                        ->maxLength(4),
                    Select::make('vehicle_status')
                        ->label(__('translate.vehicle.vehicle_status'))
                        ->options([
                            'active' => __('translate.vehicle.options_vehicle_status.0'),
                            'inactive' => __('translate.vehicle.options_vehicle_status.1'),
                            'sold' => __('translate.vehicle.options_vehicle_status.2'),
                            'eliminated' => __('translate.vehicle.options_vehicle_status.3'),
                        ])
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('license_plate')
                    ->label(__('translate.vehicle.license_plate'))
                    ->searchable(),
                TextColumn::make('brand')
                    ->label(__('translate.vehicle.brand'))
                    ->searchable(),
                TextColumn::make('style')
                    ->label(__('translate.vehicle.style'))
                    ->searchable(),
                TextColumn::make('year')
                    ->label(__('translate.vehicle.year'))
                    ->searchable(),
                TextColumn::make('vehicle_status')
                    ->label(__('translate.vehicle.vehicle_status'))
                    ->badge()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'active' => __('translate.vehicle.options_vehicle_status.0'),
                            'inactive' => __('translate.vehicle.options_vehicle_status.1'),
                            'sold' => __('translate.vehicle.options_vehicle_status.2'),
                            'eliminated' => __('translate.vehicle.options_vehicle_status.3'),
                        };
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'sold' => 'info',
                        'eliminated' => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label(__('translate.vehicle.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.vehicle.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                CommentsAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
