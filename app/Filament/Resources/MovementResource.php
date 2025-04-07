<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Models\Movement;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
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

class MovementResource extends Resource
{
    protected static ?string $model = Movement::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.movement.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.movement.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.movement.navigation');
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
                Section::make(__('resources.movement.sectionMovement'))
                ->columns(2)
                ->schema([
                    Select::make('movement_type')
                        ->label(__('translate.movement.movement_type'))
                        ->options([
                            'out' => __('translate.movement.options_movement_type.0'),
                            'in' => __('translate.movement.options_movement_type.1'),
                        ])
                        ->required(),
                    DateTimePicker::make('movement_date')
                        ->label(__('translate.movement.movement_date'))
                        ->required(),
                    Select::make('vehicle_id')
                        ->relationship(name: 'vehicle', titleAttribute:'license_plate')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('initial_mileage')
                        ->label(__('translate.movement.initial_mileage'))
                        ->maxLength(20),
                    TextInput::make('final_mileage')
                        ->label(__('translate.movement.final_mileage'))
                        ->maxLength(20),
                    FileUpload::make('attachments')
                        ->label(__('translate.movement.attachments'))
                        ->multiple()
                        ->downloadable()
                        ->directory('attachments/' .now()->format('Y/m/d'))
                        ->maxFiles(5),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('movement_type')
                    ->label(__('translate.movement.movement_type'))
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'out' => __('translate.movement.options_movement_type.0'),
                            'in' => __('translate.movement.options_movement_type.1'),
                        };
                    })
                    ->searchable(),
                TextColumn::make('movement_date')
                    ->label(__('translate.movement.movement_date'))
                    ->dateTime(),
                TextColumn::make('vehicle.license_plate')
                    ->label(__('translate.movement.vehicle_id'))
                    ->searchable(),
                TextColumn::make('initial_mileage')
                    ->label(__('translate.movement.initial_mileage'))
                    ->searchable(),
                TextColumn::make('final_mileage')
                    ->label(__('translate.movement.final_mileage'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('translate.movement.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.movement.updated_at'))
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
            'index' => Pages\ListMovements::route('/'),
            'create' => Pages\CreateMovement::route('/create'),
            'edit' => Pages\EditMovement::route('/{record}/edit'),
        ];
    }
}
