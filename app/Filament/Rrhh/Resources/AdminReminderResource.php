<?php

namespace App\Filament\Rrhh\Resources;

use App\Filament\Rrhh\Resources\AdminReminderResource\Pages;
use App\Filament\Rrhh\Resources\AdminReminderResource\RelationManagers;
use App\Models\AdminReminder;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class AdminReminderResource extends Resource
{
    protected static ?string $model = AdminReminder::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.admin_reminder.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.admin_reminder.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.admin_reminder.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.operation.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.admin_reminder.reminder_section'))
                    ->columns(2)
                    ->schema([
                        Select::make('reminder_type')
                            ->label(__('translate.admin_reminder.reminder_type'))
                            ->options(__('translate.admin_reminder.options_reminder_type'))
                            ->required(),
                        DatePicker::make('follow_up_date')
                            ->label(__('translate.admin_reminder.follow_up_date'))
                            ->required(),
                        Select::make('frequency')
                            ->label(__('translate.admin_reminder.frequency'))
                            ->options(__('translate.admin_reminder.options_frequency'))
                            ->required(),
                        Textarea::make('task_details')
                            ->label(__('translate.admin_reminder.task_details'))
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reminder_type')
                    ->label(__('translate.admin_reminder.reminder_type'))
                    ->formatStateUsing(fn($state) => __('translate.admin_reminder.options_reminder_type.' . $state))
                    ->badge()
                    ->alignCenter()
                    ->searchable(),
                TextColumn::make('follow_up_date')
                    ->label(__('translate.admin_reminder.follow_up_date'))
                    ->date()
                    ->alignCenter()
                    ->searchable(),
                TextColumn::make('frequency')
                    ->label(__('translate.admin_reminder.frequency'))
                    ->formatStateUsing(fn($state) => __('translate.admin_reminder.options_frequency.' . $state))
                    ->badge()
                    ->alignCenter()
                    ->searchable(),
                TextColumn::make('task_details')
                    ->label(__('translate.admin_reminder.task_details'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('translate.admin_reminder.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.admin_reminder.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('reminder_type')
                    ->label(__('translate.admin_reminder.reminder_type'))
                    ->options(__('translate.admin_reminder.options_reminder_type')),
                SelectFilter::make('frequency')
                    ->label(__('translate.admin_reminder.frequency'))
                    ->options(__('translate.admin_reminder.options_frequency')),
            ])
            ->actions([
                CommentsAction::make()
                    ->color('info'),
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
