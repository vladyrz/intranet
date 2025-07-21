<?php

namespace App\Filament\Ops\Resources;

use App\Filament\Ops\Resources\CampaignSocialResource\Pages;
use App\Filament\Ops\Resources\CampaignSocialResource\RelationManagers;
use App\Models\CampaignSocial;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class CampaignSocialResource extends Resource
{
    protected static ?string $model = CampaignSocial::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.campaign_social.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.campaign_social.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.campaign_social.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.campaign_social.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-share';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.campaign_social.section_campaign_social'))
                    ->columns(3)
                    ->schema([
                        Select::make('campaign_id')
                            ->label(__('translate.campaign_social.campaign_id'))
                            ->relationship(
                                name: 'campaign',
                                titleAttribute: 'title',
                            )
                            ->preload()
                            ->searchable()
                            ->required(),
                        Select::make('platform')
                            ->label(__('translate.campaign_social.platform'))
                            ->options(__('translate.campaign_social.options_platform'))
                            ->required(),
                        TextInput::make('link')
                            ->label(__('translate.campaign_social.link'))
                            ->url()
                            ->required(),
                        TextInput::make('reactions')
                            ->label(__('translate.campaign_social.reactions'))
                            ->integer(),
                        TextInput::make('comments')
                            ->label(__('translate.campaign_social.comments'))
                            ->integer(),
                        TextInput::make('shares')
                            ->label(__('translate.campaign_social.shares'))
                            ->integer(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('campaign.title')
                    ->label(__('translate.campaign_social.campaign_id'))
                    ->searchable()
                    ->alignLeft(),
                TextColumn::make('campaign.user.name')
                    ->label(__('translate.campaign.user_id'))
                    ->searchable()
                    ->alignLeft(),
                TextColumn::make('platform')
                    ->label(__('translate.campaign_social.platform'))
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => __('translate.campaign_social.options_platform.' . $state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'facebook' => 'info',
                        'instagram' => 'danger',
                        'linkedin' => 'info',
                        'youtube' => 'danger',
                        'tiktok' => 'gray',
                    }),
                TextColumn::make('link')
                    ->label(__('translate.campaign_social.link'))
                    ->alignLeft()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('reactions')
                    ->label(__('translate.campaign_social.reactions'))
                    ->alignRight()
                    ->numeric(),
                TextColumn::make('comments')
                    ->label(__('translate.campaign_social.comments'))
                    ->alignRight()
                    ->numeric(),
                TextColumn::make('shares')
                    ->label(__('translate.campaign_social.shares'))
                    ->alignRight()
                    ->numeric(),
                TextColumn::make('created_at')
                    ->label(__('translate.campaign_social.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.campaign_social.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('platform')
                    ->label(__('translate.campaign_social.platform'))
                    ->options(__('translate.campaign_social.options_platform')),
            ])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()
                        ->color('info'),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCampaignSocials::route('/'),
            'create' => Pages\CreateCampaignSocial::route('/create'),
            'edit' => Pages\EditCampaignSocial::route('/{record}/edit'),
        ];
    }
}
