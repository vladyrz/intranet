<?php

namespace App\Filament\Exitcr\Resources;

use App\Filament\Exitcr\Resources\MaintenanceResource\Pages;
use App\Filament\Exitcr\Resources\MaintenanceResource\RelationManagers;
use App\Models\Maintenance;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class MaintenanceResource extends Resource
{
    protected static ?string $model = Maintenance::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.maintenance.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.maintenance.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.maintenance.navigation');
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
                Section::make(__('resources.maintenance.sectionMaintenance'))
                ->columns(2)
                ->schema([
                    Select::make('maintenance_type')
                        ->label(__('translate.maintenance.maintenance_type'))
                        ->options([
                            'cleaning' => __('translate.maintenance.options_maintenance_type.0'),
                            'repair' => __('translate.maintenance.options_maintenance_type.1'),
                            'maintenance' => __('translate.maintenance.options_maintenance_type.2'),
                            'other' => __('translate.maintenance.options_maintenance_type.3'),
                        ])
                        ->required(),
                    Select::make('vehicle_id')
                        ->relationship(name: 'vehicle', titleAttribute:'license_plate')
                        ->searchable()
                        ->preload()
                        ->required(),
                    DateTimePicker::make('maintenance_date')
                        ->label(__('translate.maintenance.maintenance_date'))
                        ->required(),
                    FileUpload::make('attachments')
                        ->label(__('translate.maintenance.attachments'))
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
                TextColumn::make('maintenance_type')
                    ->label(__('translate.maintenance.maintenance_type'))
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'cleaning' => __('translate.maintenance.options_maintenance_type.0'),
                            'repair' => __('translate.maintenance.options_maintenance_type.1'),
                            'maintenance' => __('translate.maintenance.options_maintenance_type.2'),
                            'other' => __('translate.maintenance.options_maintenance_type.3'),
                        };
                    })
                    ->searchable(),
                TextColumn::make('vehicle.license_plate')
                    ->label(__('translate.maintenance.vehicle_id'))
                    ->searchable(),
                TextColumn::make('maintenance_date')
                    ->label(__('translate.maintenance.maintenance_date'))
                    ->dateTime(),
                TextColumn::make('created_at')
                    ->label(__('translate.maintenance.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.maintenance.updated_at'))
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
            'index' => Pages\ListMaintenances::route('/'),
            'create' => Pages\CreateMaintenance::route('/create'),
            'edit' => Pages\EditMaintenance::route('/{record}/edit'),
        ];
    }
}
