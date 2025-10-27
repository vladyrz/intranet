<?php

namespace App\Filament\Sales\Resources;

use App\Filament\Resources\CampaignResource\RelationManagers\CampaignSocialsRelationManager;
use App\Filament\Sales\Resources\CampaignResource\Pages;
use App\Filament\Sales\Resources\CampaignResource\RelationManagers;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.campaign.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.campaign.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.campaign.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.campaign.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.campaign.section_campaign'))
                    ->columns(3)
                    ->schema([
                        TextInput::make('title')
                            ->label(__('translate.campaign.title'))
                            ->required(),
                        Select::make('campaign_status')
                            ->label(__('translate.campaign.campaign_status'))
                            ->options(__('translate.campaign.options_campaign_status'))
                            ->required(),
                        Select::make('user_id')
                            ->label(__('translate.campaign.user_id'))
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('state', true),
                            )
                            ->preload()
                            ->searchable()
                            ->required(),
                        DatePicker::make('post_date')
                            ->label(__('translate.campaign.post_date')),
                        TextInput::make('marketplace_link')
                            ->label(__('translate.campaign.marketplace_link'))
                            ->url(),
                        Textarea::make('results_observations')
                            ->label(__('translate.campaign.results_observations')),
                    ]),

                Section::make(__('resources.campaign.section_scheduled'))
                    ->columns(3)
                    ->visible(fn (Get $get): bool => $get('campaign_status') == 'scheduled')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label(__('translate.campaign.start_date'))
                            ->visible(fn (Get $get): bool => $get('campaign_status') == 'scheduled')
                            ->disabled(),
                        DatePicker::make('end_date')
                            ->label(__('translate.campaign.end_date'))
                            ->visible(fn (Get $get): bool => $get('campaign_status') == 'scheduled')
                            ->disabled(),
                        Select::make('social_network')
                            ->label(__('translate.campaign.social_network'))
                            ->options(__('translate.campaign_social.options_platform'))
                            ->visible(fn (Get $get): bool => $get('campaign_status') == 'scheduled')
                            ->disabled(),
                        Textarea::make('rejection_reason')
                            ->label(__('translate.campaign.rejection_reason'))
                            ->visible(fn (Get $get): bool => $get('campaign_status') == 'rejected'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('translate.campaign.title'))
                    ->searchable()
                    ->alignLeft(),
                TextColumn::make('campaign_status')
                    ->label(__('translate.campaign.campaign_status'))
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => __('translate.campaign.options_campaign_status.' . $state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'active' => 'success',
                        'inactive' => 'danger',
                        'finished' => 'info',
                        'to_schedule' => 'gray',
                        'scheduled' => 'info',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'active' => 'heroicon-o-check-circle',
                        'inactive' => 'heroicon-o-minus-circle',
                        'finished' => 'heroicon-o-check-circle',
                        'to_schedule' => 'heroicon-o-calendar',
                        'scheduled' => 'heroicon-o-calendar-date-range',
                    }),
                TextColumn::make('user.name')
                    ->label(__('translate.campaign.user_id'))
                    ->searchable()
                    ->alignLeft(),
                TextColumn::make('post_date')
                    ->label(__('translate.campaign.post_date'))
                    ->date()
                    ->alignCenter(),
                TextColumn::make('marketplace_link')
                    ->label(__('translate.campaign.marketplace_link'))
                    ->alignLeft()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('results_observations')
                    ->label(__('translate.campaign.results_observations'))
                    ->alignLeft()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('translate.campaign.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.campaign.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('campaign_status')
                    ->label(__('translate.campaign.campaign_status'))
                    ->options(__('translate.campaign.options_campaign_status')),
            ])
            ->actions([
                CommentsAction::make()
                    ->color('info'),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CampaignSocialsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
