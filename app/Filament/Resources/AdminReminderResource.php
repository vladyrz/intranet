<?php

namespace App\Filament\Resources;

use App\Enums\ReminderFrequency;
use App\Enums\ReminderType;
use App\Filament\Resources\AdminReminderResource\Pages;
use App\Models\AdminReminder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminReminderResource extends Resource
{
    protected static ?string $model = AdminReminder::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Reminder Configuration')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->label('Recipient User'),

                        Forms\Components\Select::make('frequency')
                            ->options(ReminderFrequency::class)
                            ->required()
                            ->enum(ReminderFrequency::class),

                        Forms\Components\Select::make('type')
                            ->options(ReminderType::class)
                            ->required()
                            ->enum(ReminderType::class),

                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->rows(3),
                    ])->columns(2),

                Forms\Components\Section::make('Scheduling')
                    ->schema([
                        Forms\Components\DatePicker::make('starts_at')
                            ->required()
                            ->default(now()->addDay()->startOfDay()->addHours(8))
                            ->label('Starts At (First Run)'),

                        Forms\Components\DatePicker::make('ends_at')
                            ->label('Ends At (Optional)'),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Active'),
                    ])->columns(2),

                Forms\Components\Section::make('Status & History')
                    ->schema([
                        Forms\Components\Placeholder::make('next_run_at')
                            ->content(fn(?AdminReminder $record) => $record?->next_run_at?->format('Y-m-d H:i:s') ?? 'Pending calculation'),

                        Forms\Components\Placeholder::make('last_sent_at')
                            ->content(fn(?AdminReminder $record) => $record?->last_sent_at?->format('Y-m-d H:i:s') ?? 'Never'),

                        Forms\Components\Placeholder::make('failure_count')
                            ->content(fn(?AdminReminder $record) => $record?->failure_count ?? 0),

                        Forms\Components\Placeholder::make('last_error_message')
                            ->content(fn(?AdminReminder $record) => $record?->last_error_message ?? 'None')
                            ->visible(fn(?AdminReminder $record) => !empty($record?->last_error_message)),
                    ])->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User'),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('frequency')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('next_run_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('last_sent_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('failure_count')
                    ->numeric()
                    ->sortable()
                    ->color(fn(int $state) => $state > 0 ? 'danger' : 'success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('frequency')
                    ->options(ReminderFrequency::class),

                Tables\Filters\SelectFilter::make('type')
                    ->options(ReminderType::class),

                Tables\Filters\Filter::make('active')
                    ->query(fn(Builder $query) => $query->where('is_active', true)),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminReminders::route('/'),
            'create' => Pages\CreateAdminReminder::route('/create'),
            'edit' => Pages\EditAdminReminder::route('/{record}/edit'),
        ];
    }
}
