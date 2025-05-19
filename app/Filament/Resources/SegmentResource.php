<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SegmentResource\Pages;
use App\Filament\Resources\SegmentResource\RelationManagers;
use App\Models\Segment;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class SegmentResource extends Resource
{
    protected static ?string $model = Segment::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.segment.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.segment.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.segment.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.employee.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.segment.section_agent'))
                    ->columns(2)
                    ->schema([
                        Select::make('employee_id')
                            ->label(__('translate.segment.employee_id'))
                            ->relationship(
                                name: 'employee',
                                titleAttribute: 'name',
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('experience')
                            ->label(__('translate.segment.experience'))
                            ->options(__('translate.segment.options_experience'))
                            ->required(),
                        Select::make('location')
                            ->label(__('translate.segment.location'))
                            ->options(__('translate.segment.options_location'))
                            ->required(),
                        Select::make('availability_status')
                            ->label(__('translate.segment.availability_status'))
                            ->options(__('translate.segment.options_availability_status'))
                            ->required(),
                    ]),
                Section::make(__('resources.segment.section_performance'))
                    ->columns(4)
                    ->schema([
                        TextInput::make('assigned_active_properties')
                            ->label(__('translate.segment.assigned_active_properties'))
                            ->maxLength(5)
                            ->required(),
                        TextInput::make('coordinated_visits')
                            ->label(__('translate.segment.coordinated_visits'))
                            ->maxLength(5),
                        TextInput::make('active_leads_follow_up')
                            ->label(__('translate.segment.active_leads_follow_up'))
                            ->maxLength(5),
                        TextInput::make('closed_deals')
                            ->label(__('translate.segment.closed_deals'))
                            ->maxLength(5),
                    ]),
                Section::make(__('resources.segment.section_skills'))
                    ->columns(1)
                    ->schema([
                        TagsInput::make('additional_skills')
                            ->label(__('translate.segment.additional_skills'))
                            ->separator(',')
                            ->suggestions(__('translate.segment.tags'))
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label(__('translate.segment.employee_id'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('experience')
                    ->label(__('translate.segment.experience'))
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => __('translate.segment.options_experience.' . $state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'gray',
                        'intermediate' => 'info',
                        'advanced' => 'success',
                        'specialized' => 'warning',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'new' => 'heroicon-o-light-bulb',
                        'intermediate' => 'heroicon-o-chart-bar',
                        'advanced' => 'heroicon-o-briefcase',
                        'specialized' => 'heroicon-o-trophy',
                    }),
                TextColumn::make('location')
                    ->label(__('translate.segment.location'))
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => __('translate.segment.options_location.' . $state))
                    ->limit(20),
                TextColumn::make('availability_status')
                    ->label(__('translate.segment.availability_status'))
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(fn($state) => __('translate.segment.options_availability_status.' . $state))
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'busy' => 'warning',
                        'unavailable' => 'danger',
                    }),
                TextColumn::make('assigned_active_properties')
                    ->label(__('translate.segment.assigned_active_properties'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('coordinated_visits')
                    ->label(__('translate.segment.coordinated_visits'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('active_leads_follow_up')
                    ->label(__('translate.segment.active_leads_follow_up'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('closed_deals')
                    ->label(__('translate.segment.closed_deals'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('additional_skills')
                    ->label(__('translate.segment.additional_skills'))
                    ->badge()
                    ->separator(',')
                    ->limit(5)
                    ->tooltip(function ($state) {
                        return is_array($state) ? implode(', ', $state) : null;
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->label(__('translate.segment.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.segment.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('location')
                    ->label(__('translate.segment.location'))
                    ->options(__('translate.segment.options_location')),
                SelectFilter::make('availability_status')
                    ->label(__('translate.segment.availability_status'))
                    ->options(__('translate.segment.options_availability_status')),
            ])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()
                        ->color('info'),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make()
                ]),
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
            'index' => Pages\ListSegments::route('/'),
            'create' => Pages\CreateSegment::route('/create'),
            'edit' => Pages\EditSegment::route('/{record}/edit'),
        ];
    }
}
