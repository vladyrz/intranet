<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccesRequestResource\Pages;
use App\Filament\Resources\AccesRequestResource\RelationManagers;
use App\Models\AccesRequest;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccesRequestResource extends Resource
{
    protected static ?string $model = AccesRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship(name: 'user', titleAttribute:'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('type_of_request')
                    ->options([
                        'pickup' => 'Pickup',
                        'visit' => 'Visit',
                        'both' => 'Both',
                    ])
                    ->required()
                    ->reactive(),
                TextInput::make('property')
                    ->required(),
                Select::make('organization_id')
                    ->relationship(name: 'organization', titleAttribute:'organization_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                DateTimePicker::make('pickup_datetime')
                    ->visible(fn (Get $get): bool => in_array($get('type_of_request'), ['pickup', 'both'])),
                DateTimePicker::make('visit_datetime')
                    ->visible(fn (Get $get): bool => in_array($get('type_of_request'), ['visit', 'both'])),
                Select::make('request_status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('type_of_request')
                    ->searchable(),
                TextColumn::make('user.employee.national_id')
                    ->searchable(),
                TextColumn::make('property'),
                TextColumn::make('organization.organization_name'),
                TextColumn::make('pickup_datetime')
                    ->dateTime(),
                TextColumn::make('visit_datetime')
                    ->dateTime(),
                TextColumn::make('request_status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
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
            'index' => Pages\ListAccesRequests::route('/'),
            'create' => Pages\CreateAccesRequest::route('/create'),
            'edit' => Pages\EditAccesRequest::route('/{record}/edit'),
        ];
    }
}
