<?php

namespace App\Filament\Ops\Resources;

use App\Filament\Ops\Resources\DepartamentResource\Pages;
use App\Filament\Ops\Resources\DepartamentResource\RelationManagers;
use App\Models\Departament;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartamentResource extends Resource
{
    protected static ?string $model = Departament::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.departament.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.departament.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.departament.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.operation.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.departament.sectionDepartment'))
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('translate.departament.name'))
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label(__('translate.departament.description'))
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('translate.departament.name'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('description')
                    ->label(__('translate.departament.description'))
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartaments::route('/'),
            'create' => Pages\CreateDepartament::route('/create'),
            'edit' => Pages\EditDepartament::route('/{record}/edit'),
        ];
    }
}
