<?php

namespace App\Filament\Sales\Resources;

use App\Filament\Sales\Resources\AccesRequestResource\Pages;
use App\Filament\Sales\Resources\AccesRequestResource\RelationManagers;
use App\Models\AccesRequest;
use App\Models\PersonalCustomer;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
use Illuminate\Support\Collection;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class AccesRequestResource extends Resource
{
    protected static ?string $model = AccesRequest::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.acces_request.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.acces_request.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.acces_request.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.employee.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.acces_request.sectionRequest'))
                    ->description(__('resources.acces_request.section_description'))
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label(__('translate.access_request.user_id'))
                            ->relationship(name: 'user', titleAttribute:'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set){
                                $set('peronal_customer_id', null);
                            }),
                        Select::make('type_of_request')
                            ->label(__('translate.access_request.type_of_request'))
                            ->options(__('translate.access_request.options_type_of_request'))
                            ->required(),
                        TextInput::make('property')
                            ->label(__('translate.access_request.property'))
                            ->required(),
                        Select::make('organization_id')
                            ->label(__('translate.access_request.organization_id'))
                            ->relationship(name: 'organization', titleAttribute:'organization_name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        DateTimePicker::make('pickup_datetime')
                            ->label(__('translate.access_request.pickup_datetime')),
                        DateTimePicker::make('visit_datetime')
                            ->label(__('translate.access_request.visit_datetime')),
                        Select::make('personal_customer_id')
                            ->label(__('translate.access_request.personal_customer_id'))
                            ->options(fn (Get $get): Collection => PersonalCustomer::query()
                                ->where('user_id', $get('user_id'))
                                ->pluck('full_name', 'id')
                            )
                            ->searchable()
                            ->preload(),
                        Select::make('request_status')
                            ->label(__('translate.access_request.request_status'))
                            ->options([
                                'received' => __('translate.access_request.options_request_status.1'),
                                'sent' => __('translate.access_request.options_request_status.2'),
                                'approved' => __('translate.access_request.options_request_status.3'),
                                'rejected' => __('translate.access_request.options_request_status.4'),
                            ])
                            ->reactive()
                            ->required(),
                        Textarea::make('user_comments')
                            ->label(__('translate.access_request.user_comments')),
                        Textarea::make('rejection_reason')
                            ->label(__('translate.offer.rejection_reason'))
                            ->visible(fn (Get $get): bool => $get('request_status') == 'rejected'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('translate.access_request.user_id'))
                    ->searchable()
                    ->alignLeft(),
                TextColumn::make('type_of_request')
                    ->label(__('translate.access_request.type_of_request'))
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => __('translate.access_request.options_type_of_request.' . $state))
                    ->searchable(),
                TextColumn::make('user.employee.national_id')
                    ->label(__('translate.access_request.user_national_id'))
                    ->searchable()
                    ->alignRight()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('property')
                    ->label(__('translate.access_request.property'))
                    ->alignRight()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('organization.organization_name')
                    ->label(__('translate.access_request.organization_id'))
                    ->searchable()
                    ->alignLeft()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('visit_datetime')
                    ->label(__('translate.access_request.visit_datetime'))
                    ->dateTime()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('pickup_datetime')
                    ->label(__('translate.access_request.pickup_datetime'))
                    ->dateTime()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('personal_customer.full_name')
                    ->label(__('translate.access_request.personal_customer_id'))
                    ->searchable()
                    ->alignLeft()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('personal_customer.national_id')
                    ->label(__('translate.access_request.personal_customer_national_id'))
                    ->searchable()
                    ->alignRight()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('personal_customer.license_plate')
                    ->label(__('translate.access_request.personal_customer_license_plate'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('request_status')
                    ->label(__('translate.access_request.request_status'))
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'pending' => __('translate.access_request.options_request_status.0'),
                            'received' => __('translate.access_request.options_request_status.1'),
                            'sent' => __('translate.access_request.options_request_status.2'),
                            'approved' => __('translate.access_request.options_request_status.3'),
                            'rejected' => __('translate.access_request.options_request_status.4'),
                        };
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'received' => 'info',
                        'sent' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                TextColumn::make('rejection_reason')
                    ->label(__('translate.offer.rejection_reason'))
                    ->alignLeft()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('translate.access_request.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.access_request.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type_of_request')
                    ->label(__('translate.access_request.type_of_request'))
                    ->options(__('translate.access_request.options_type_of_request')),
                SelectFilter::make('organization_id')
                    ->label(__('translate.access_request.organization_id'))
                    ->relationship(name: 'organization', titleAttribute:'organization_name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                CommentsAction::make()
                    ->color('info'),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
