<?php

namespace App\Filament\Soporte\Resources;

use App\Filament\Soporte\Resources\OfferResource\Pages;
use App\Filament\Soporte\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use App\Models\PersonalCustomer;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.offer.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.offer.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.offer.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.employee.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.offer.section_offer'))
                    ->columns(3)
                    ->schema([
                        TextInput::make('property_name')
                            ->label(__('translate.offer.property_name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('property_value_usd')
                            ->label(__('translate.offer.property_value_usd'))
                            ->numeric(),
                        TextInput::make('property_value_crc')
                            ->label(__('translate.offer.property_value_crc'))
                            ->numeric(),
                        Select::make('organization_id')
                            ->label(__('translate.offer.organization_id'))
                            ->relationship(
                                name: 'organization',
                                titleAttribute: 'organization_name',
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('user_id')
                            ->label(__('translate.offer.user_id'))
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name',
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set){
                                $set('personal_customer_id', null);
                            }),
                        Select::make('personal_customer_id')
                            ->label(__('translate.offer.personal_customer_id'))
                            ->options(fn (Get $get): Collection => PersonalCustomer::query()
                                ->where('user_id', $get('user_id'))
                                ->pluck('full_name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('offer_amount_usd')
                            ->label(__('translate.offer.offer_amount_usd'))
                            ->numeric(),
                        TextInput::make('offer_amount_crc')
                            ->label(__('translate.offer.offer_amount_crc'))
                            ->numeric(),
                        Select::make('offer_status')
                            ->label(__('translate.offer.offer_status'))
                            ->options([
                                'sent' => __('translate.offer.options_offer_status.1'),
                                'approved' => __('translate.offer.options_offer_status.2'),
                                'rejected' => __('translate.offer.options_offer_status.3'),
                                'signed' => __('translate.offer.options_offer_status.4'),
                            ])
                            ->required(),
                        FileUpload::make('offer_files')
                            ->label(__('translate.offer.offer_files'))
                            ->multiple()
                            ->columnSpanFull()
                            ->downloadable()
                            ->directory('attachments/' .now()->format('Y/m/d'))
                            ->minFiles(1)
                            ->maxFiles(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('property_name')
                    ->label(__('translate.offer.property_name'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('property_value_usd')
                    ->label(__('translate.offer.property_value_usd'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('property_value_crc')
                    ->label(__('translate.offer.property_value_crc'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('organization.organization_name')
                    ->label(__('translate.offer.organization_id'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('user.name')
                    ->label(__('translate.offer.user_id'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('personal_customer.full_name')
                    ->label(__('translate.offer.personal_customer_id'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('personal_customer.national_id')
                    ->label(__('translate.offer.personal_customer_national_id'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('personal_customer.phone_number')
                    ->label(__('translate.offer.personal_customer_phone_number'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('personal_customer.email')
                    ->label(__('translate.offer.personal_customer_email'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('offer_amount_usd')
                    ->label(__('translate.offer.offer_amount_usd'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('offer_amount_crc')
                    ->label(__('translate.offer.offer_amount_crc'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('offer_status')
                    ->label(__('translate.offer.offer_status'))
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'pending' => __('translate.offer.options_offer_status.0'),
                            'sent' => __('translate.offer.options_offer_status.1'),
                            'approved' => __('translate.offer.options_offer_status.2'),
                            'rejected' => __('translate.offer.options_offer_status.3'),
                            'signed' => __('translate.offer.options_offer_status.4'),
                        };
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'sent' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'signed' => 'info',
                    }),
                TextColumn::make('created_at')
                    ->label(__('translate.offer.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.offer.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('organization_id')
                    ->label(__('translate.offer.organization_id'))
                    ->relationship(
                        name: 'organization',
                        titleAttribute: 'organization_name',
                    )
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()
                        ->color('info'),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make()
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null);
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
