<?php

namespace App\Filament\Personal\Resources;

use App\Filament\Personal\Resources\CustomerResource\Pages;
use App\Filament\Personal\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.customer.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.customer.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.customer.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.customer.navigation_group');
    }

    public static function getNavigationBadge(): ?string
    {
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id)->where('state', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id)->where('state','pending')->count() > 0 ? 'warning' : 'primary';
    }

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

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
                Section::make(__('resources.customer.sectionCustomer'))
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('full_name')
                        ->label(__('translate.customer.full_name'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('national_id')
                        ->label(__('translate.customer.national_id'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label(__('translate.customer.email'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone_number')
                        ->label(__('translate.customer.phone_number'))
                        ->maxLength(20),
                    Forms\Components\Select::make('customer_type')
                        ->label(__('translate.customer.customer_type'))
                        ->options([
                            'buyer' => __('translate.customer.options_cust_type.0'),
                            'seller' => __('translate.customer.options_cust_type.1'),
                            'investor' => __('translate.customer.options_cust_type.2'),
                            'tenant' => __('translate.customer.options_cust_type.3'),
                            'other' => __('translate.customer.options_cust_type.4'),
                        ]),
                    Forms\Components\TextInput::make('property_name')
                        ->label(__('translate.customer.property_name'))
                        ->maxLength(255),
                    Forms\Components\Select::make('organization_id')
                        ->label(__('translate.customer.organization_id'))
                        ->relationship(
                            name: 'organization',
                            titleAttribute: 'organization_name'
                        ),
                    Forms\Components\Textarea::make('address')
                        ->label(__('translate.customer.address'))
                        ->columnSpan(2),
                ]),

                Section::make(__('resources.customer.section_source_customer'))
                ->columns(3)
                ->schema([
                    Forms\Components\Select::make('contact_source')
                        ->label(__('translate.customer.contact_source'))
                        ->options([
                            'hubspot' => __('translate.customer.options_contact_source.0'),
                            'referred' => __('translate.customer.options_contact_source.1'),
                            'easychat' => __('translate.customer.options_contact_source.2'),
                            'whatsapp' => __('translate.customer.options_contact_source.3'),
                            'email' => __('translate.customer.options_contact_source.4'),
                            'other' => __('translate.customer.options_contact_source.5')
                        ]),
                    Forms\Components\Select::make('contact_preferences')
                        ->label(__('translate.customer.contact_preferences'))
                        ->options([
                            'email' => __('translate.customer.options_cpreferences.0'),
                            'whatsapp' => __('translate.customer.options_cpreferences.1'),
                            'phone' => __('translate.customer.options_cpreferences.2'),
                            'other' => __('translate.customer.options_cpreferences.3'),
                        ]),
                    Forms\Components\DatePicker::make('initial_contact_date')
                        ->label(__('translate.customer.initial_contact_date')),
                ]),

                Section::make(__('resources.customer.section_financial'))
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('budget_usd')
                        ->label(__('translate.customer.budget_usd')),
                    Forms\Components\TextInput::make('budget_crc')
                        ->label(__('translate.customer.budget_crc')),
                    Forms\Components\TextInput::make('expected_commission_usd')
                        ->label(__('translate.customer.expected_commission_usd')),
                    Forms\Components\TextInput::make('expected_commission_crc')
                        ->label(__('translate.customer.expected_commission_crc')),
                    Forms\Components\Toggle::make('financing')
                        ->label(__('translate.customer.financing')),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('translate.customer.customer_name'))
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('national_id')
                    ->label(__('translate.customer.national_id'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('translate.customer.email'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('translate.customer.phone_number'))
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('contact_source')
                    ->label(__('translate.customer.contact_source'))
                    ->alignCenter()
                    ->searchable()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'hubspot' => __('translate.customer.options_contact_source.0'),
                            'referred' => __('translate.customer.options_contact_source.1'),
                            'easychat' => __('translate.customer.options_contact_source.2'),
                            'whatsapp' => __('translate.customer.options_contact_source.3'),
                            'email' => __('translate.customer.options_contact_source.4'),
                            'other' => __('translate.customer.options_contact_source.5'),
                        };
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('property_name')
                    ->label(__('translate.customer.property_name'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('organization.organization_name')
                    ->label(__('translate.customer.organization_id'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('translate.customer.address'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact_preferences')
                    ->label(__('translate.customer.contact_preferences'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'email' => __('translate.customer.options_cpreferences.0'),
                            'whatsapp' => __('translate.customer.options_cpreferences.1'),
                            'phone' => __('translate.customer.options_cpreferences.2'),
                            'other' => __('translate.customer.options_cpreferences.3')
                        };
                    }),
                Tables\Columns\TextColumn::make('initial_contact_date')
                    ->label(__('translate.customer.initial_contact_date'))
                    ->alignCenter()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('customer_type')
                    ->label(__('translate.customer.customer_type'))
                    ->alignCenter()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'buyer' => __('translate.customer.options_cust_type.0'),
                            'seller' => __('translate.customer.options_cust_type.1'),
                            'investor' => __('translate.customer.options_cust_type.2'),
                            'tenant' => __('translate.customer.options_cust_type.3'),
                            'other' => __('translate.customer.options_cust_type.4')
                        };
                    }),
                // Tables\Columns\TextColumn::make('credid_information')
                //     ->searchable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('budget_usd')
                    ->label(__('translate.customer.budget_usd'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('budget_crc')
                    ->label(__('translate.customer.budget_crc'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('expected_commission_usd')
                    ->label(__('translate.customer.expected_commission_usd'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('expected_commission_crc')
                    ->label(__('translate.customer.expected_commission_crc'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\IconColumn::make('financing')
                    ->label(__('translate.customer.financing'))
                    ->alignCenter()
                    ->boolean(),
                Tables\Columns\TextColumn::make('state')
                    ->label(__('translate.customer.state'))
                    ->alignCenter()
                    ->searchable()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'pending' => __('translate.customer.options_state.0'),
                            'rejected' => __('translate.customer.options_state.1'),
                            'approved' => __('translate.customer.options_state.2'),
                            'in_process' => __('translate.customer.options_state.3'),
                        };
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        'approved' => 'success',
                        'in_process' => 'info',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('translate.customer.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('translate.customer.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('contact_source')
                    ->label(__('translate.customer.contact_source'))
                    ->options([
                        'hubspot' => __('translate.customer.options_contact_source.0'),
                        'referred' => __('translate.customer.options_contact_source.1'),
                        'easychat' => __('translate.customer.options_contact_source.2'),
                        'whatsapp' => __('translate.customer.options_contact_source.3'),
                        'email' => __('translate.customer.options_contact_source.4'),
                        'other' => __('translate.customer.options_contact_source.5')
                    ]),
                SelectFilter::make('contact_preferences')
                    ->label(__('translate.customer.contact_preferences'))
                    ->options([
                        'email' => __('translate.customer.options_cpreferences.0'),
                        'whatsapp' => __('translate.customer.options_cpreferences.1'),
                        'phone' => __('translate.customer.options_cpreferences.2'),
                        'other' => __('translate.customer.options_cpreferences.3')
                    ])
            ])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()
                        ->color('info'),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                ])
            ])
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ])
            ;
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
