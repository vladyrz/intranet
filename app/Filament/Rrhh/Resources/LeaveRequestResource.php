<?php

namespace App\Filament\Rrhh\Resources;

use App\Filament\Rrhh\Resources\LeaveRequestResource\Pages;
use App\Filament\Rrhh\Resources\LeaveRequestResource\RelationManagers;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.leave_request.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.leave_request.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.leave_request.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.employee.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.leave_request.section_request'))
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label(__('translate.leave_request.user_id'))
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name'
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        Radio::make('request_type')
                            ->label(__('translate.leave_request.request_type'))
                            ->options(__('translate.leave_request.options_request_types'))
                            ->reactive()
                            ->required(),
                        Select::make('request_status')
                            ->label(__('translate.leave_request.request_status'))
                            ->options(__('translate.leave_request.options_request_status'))
                            ->required(),
                        Textarea::make('observations')
                            ->label(__('translate.leave_request.observations')),
                    ]),

                Section::make(__('resources.leave_request.section_permissions'))
                    ->columns(2)
                    ->visible(fn (Get $get) => $get('request_type') === 'permission')
                    ->schema([
                        DatePicker::make('permission_date')
                            ->label(__('translate.leave_request.permission_date'))
                            ->visible(fn (Get $get) => $get('request_type') === 'permission'),
                        Radio::make('permission_options')
                            ->label(__('translate.leave_request.permission_options'))
                            ->visible(fn (Get $get) => $get('request_type') === 'permission')
                            ->options(__('translate.leave_request.options_permissions'))
                            ->reactive(),
                        TimePicker::make('start_time')
                            ->label(__('translate.leave_request.start_time'))
                            ->visible(fn (Get $get) =>
                                $get('request_type') === 'permission' && $get('permission_options') === 'hours_range'
                            )
                            ->seconds(false),
                        TimePicker::make('end_time')
                            ->label(__('translate.leave_request.end_time'))
                            ->visible(fn (Get $get) =>
                                $get('request_type') === 'permission' && $get('permission_options') === 'hours_range'
                            )
                            ->seconds(false),
                    ]),

                Section::make(__('resources.leave_request.section_vacations'))
                    ->columns(2)
                    ->visible(fn (Get $get) => $get('request_type') === 'vacations')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label(__('translate.leave_request.start_date'))
                            ->visible(fn (Get $get) => $get('request_type') === 'vacations')
                            ->reactive()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $start = Carbon::parse($state);
                                $end = $get('end_date') ? Carbon::parse($get('end_date')) : null;

                                if ($start && $end && $start <= $end) {
                                    $days = $start->diffInDays($end->copy()->addDay());
                                    $set('total_days', $days);
                                } else {
                                    $set('total_days', null);
                                }
                            }),

                        DatePicker::make('end_date')
                            ->label(__('translate.leave_request.end_date'))
                            ->visible(fn (Get $get) => $get('request_type') === 'vacations')
                            ->reactive()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $end = Carbon::parse($state);
                                $start = $get('start_date') ? Carbon::parse($get('start_date')) : null;

                                if ($start && $end && $start <= $end) {
                                    $days = $start->diffInDays($end->copy()->addDay());
                                    $set('total_days', $days);
                                } else {
                                    $set('total_days', null);
                                }
                            }),

                        TextInput::make('total_days')
                            ->label(__('translate.leave_request.total_days'))
                            ->visible(fn (Get $get) => $get('request_type') === 'vacations')
                            ->disabled()
                            ->dehydrated(true),

                        TextInput::make('vacation_balance')
                            ->label(__('translate.leave_request.vacation_balance'))
                            ->visible(fn (Get $get) => $get('request_type') === 'vacations'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('translate.leave_request.user_id'))
                    ->searchable()
                    ->alignLeft(),
                TextColumn::make('request_type')
                    ->label(__('translate.leave_request.request_type'))
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(fn($state) => __('translate.leave_request.options_request_types.' . $state))
                    ->color(fn (string $state): string => match ($state) {
                        'permission' => 'warning',
                        'vacations' => 'info',
                    }),
                TextColumn::make('request_status')
                    ->label(__('translate.leave_request.request_status'))
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(fn($state) => __('translate.leave_request.options_request_status.' . $state))
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'denied' => 'danger',
                    }),
                TextColumn::make('observations')
                    ->label(__('translate.leave_request.observations'))
                    ->alignLeft()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->label(__('translate.leave_request.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.leave_request.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('request_type')
                    ->label(__('translate.leave_request.request_type'))
                    ->options(__('translate.leave_request.options_request_types')),
            ])
            ->actions([
                CommentsAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
