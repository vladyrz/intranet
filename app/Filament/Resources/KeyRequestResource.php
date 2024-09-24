<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeyRequestResource\Pages;
use App\Filament\Resources\KeyRequestResource\RelationManagers;
use App\Models\KeyRequest;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeyRequestResource extends Resource
{
    protected static ?string $model = KeyRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Agent Info')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship(name: 'user', titleAttribute: 'name')
                        ->required(),
                    Forms\Components\TextInput::make('national_id')
                        ->required()
                ]),
                Section::make('Main Info')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('property_id')
                        ->required(),
                    Forms\Components\DateTimePicker::make('visit_at')
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'decline' => 'Decline',
                            'approved' => 'Approved',
                            'pending' => 'Pending'
                        ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('user.state')
                    ->label('User State')
                    ->alignCenter()
                    ->boolean(),
                Tables\Columns\TextColumn::make('national_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('visit_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'decline' => 'danger',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'decline' => 'Decline',
                        'approved' => 'Approved',
                        'pending' => 'Pending',
                    ]),
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
            'index' => Pages\ListKeyRequests::route('/'),
            'create' => Pages\CreateKeyRequest::route('/create'),
            'edit' => Pages\EditKeyRequest::route('/{record}/edit'),
        ];
    }
}
