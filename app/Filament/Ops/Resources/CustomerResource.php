<?php

namespace App\Filament\Ops\Resources;

use App\Filament\Ops\Resources\CustomerResource\Pages;
use App\Filament\Ops\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
        return __('resources.employee.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.customer.sectionCustomer'))
                ->columns(3)
                ->schema([
                    Select::make('user_id')
                        ->label(__('translate.customer.user_id'))
                        ->relationship(
                            name: 'user',
                            titleAttribute: 'name',
                        ),
                    TextInput::make('full_name')
                        ->label(__('translate.customer.full_name'))
                        ->maxLength(255),
                    TextInput::make('national_id')
                        ->label(__('translate.customer.national_id'))
                        ->maxLength(255),
                    TextInput::make('email')
                        ->email()
                        ->label(__('translate.customer.email'))
                        ->maxLength(255),
                    TextInput::make('phone_number')
                        ->label(__('translate.customer.phone_number'))
                        ->maxLength(20),
                    Select::make('customer_type')
                        ->label(__('translate.customer.customer_type'))
                        ->options([
                            'buyer' => __('translate.customer.options_cust_type.0'),
                            'seller' => __('translate.customer.options_cust_type.1'),
                            'investor' => __('translate.customer.options_cust_type.2'),
                            'tenant' => __('translate.customer.options_cust_type.3'),
                            'other' => __('translate.customer.options_cust_type.4'),
                        ]),
                    TextInput::make('property_name')
                        ->label(__('translate.customer.property_name'))
                        ->maxLength(255),
                    Select::make('organization_id')
                        ->label(__('translate.customer.organization_id'))
                        ->relationship(
                            name: 'organization',
                            titleAttribute: 'organization_name',
                        ),
                    Textarea::make('address')
                        ->label(__('translate.customer.address')),
                ]),

                Section::make(__('resources.customer.section_source_customer'))
                ->columns(3)
                ->schema([
                    Select::make('contact_source')
                        ->label(__('translate.customer.contact_source'))
                        ->options([
                            'hubspot' => __('translate.customer.options_contact_source.0'),
                            'referred' => __('translate.customer.options_contact_source.1'),
                            'easychat' => __('translate.customer.options_contact_source.2'),
                            'whatsapp' => __('translate.customer.options_contact_source.3'),
                            'email' => __('translate.customer.options_contact_source.4'),
                            'other' => __('translate.customer.options_contact_source.5'),
                        ]),
                    Select::make('contact_preferences')
                        ->label(__('translate.customer.contact_preferences'))
                        ->options([
                            'email' => __('translate.customer.options_cpreferences.0'),
                            'whatsapp' => __('translate.customer.options_cpreferences.1'),
                            'phone' => __('translate.customer.options_cpreferences.2'),
                            'other' => __('translate.customer.options_cpreferences.3')
                        ]),
                    DatePicker::make('initial_contact_date')
                        ->label(__('translate.customer.initial_contact_date')),
                ]),

                Section::make(__('resources.customer.section_financial'))
                ->columns(2)
                ->schema([
                    TextInput::make('budget_usd')
                        ->label(__('translate.customer.budget_usd')),
                    TextInput::make('budget_crc')
                        ->label(__('translate.customer.budget_crc')),
                    TextInput::make('expected_commission_usd')
                        ->label(__('translate.customer.expected_commission_usd')),
                    TextInput::make('expected_commission_crc')
                        ->label(__('translate.customer.expected_commission_crc')),
                    Toggle::make('financing')
                        ->label(__('translate.customer.financing')),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('translate.customer.user_id'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('full_name')
                    ->label(__('translate.customer.customer_name'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('national_id')
                    ->label(__('translate.customer.national_id'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('email')
                    ->label(__('translate.customer.email'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('phone_number')
                    ->label(__('translate.customer.phone_number'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('contact_source')
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
                TextColumn::make('property_name')
                    ->label(__('translate.customer.property_name'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('organization.organization_name')
                    ->label(__('translate.customer.organization_id'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('address')
                    ->label(__('translate.customer.address'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('contact_preferences')
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
                TextColumn::make('initial_contact_date')
                    ->label(__('translate.customer.initial_contact_date'))
                    ->alignCenter()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('customer_type')
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
                TextColumn::make('budget_usd')
                    ->label(__('translate.customer.budget_usd'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('budget_crc')
                    ->label(__('translate.customer.budget_crc'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('expected_commission_usd')
                    ->label(__('translate.customer.expected_commission_usd'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('expected_commission_crc')
                    ->label(__('translate.customer.expected_commission_crc'))
                    ->alignCenter()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                IconColumn::make('financing')
                    ->label(__('translate.customer.financing'))
                    ->alignCenter()
                    ->boolean(),
                TextColumn::make('state')
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
                TextColumn::make('created_at')
                    ->label(__('translate.customer.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('translate.customer.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('user_id')
                    ->label(__('translate.customer.user_id'))
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                    ),
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
                    Tables\Actions\DeleteAction::make()
                ])
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}