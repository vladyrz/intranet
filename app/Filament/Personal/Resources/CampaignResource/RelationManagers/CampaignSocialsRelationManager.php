<?php

namespace App\Filament\Personal\Resources\CampaignResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class CampaignSocialsRelationManager extends RelationManager
{
    protected static string $relationship = 'campaign_socials';
    protected static ?string $title = 'Redes Sociales';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Radio::make('platform')
                    ->label(__('translate.campaign_social.platform'))
                    ->options(__('translate.campaign_social.options_platform'))
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
                TextInput::make('views')
                    ->label(__('translate.campaign_social.views'))
                    ->integer(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('platform')
            ->columns([
                TextColumn::make('language')
                    ->label(__('translate.campaign_social.language'))
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => __('translate.campaign_social.options_language.' . $state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'es' => 'info',
                        'en' => 'danger',
                    }),
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
                    ->url(fn ($record) => $record->link)
                    ->openUrlInNewTab()
                    ->limit(50)
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
                TextColumn::make('views')
                    ->label(__('translate.campaign_social.views'))
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
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('resources.campaign_social.label')),
            ])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()
                        ->color('info'),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ]);
    }
}
