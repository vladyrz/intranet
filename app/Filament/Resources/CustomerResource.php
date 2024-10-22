<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parallax\FilamentComments\Infolists\Components\CommentsEntry;
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
                    Forms\Components\TextInput::make('full_name')
                        ->label(__('translate.customer.full_name'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label(__('translate.customer.email'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone_number')
                        ->label(__('translate.customer.phone_number'))
                        ->maxLength(20),
                    Forms\Components\Select::make('contact_preferences')
                        ->label(__('translate.customer.contact_preferences'))
                        ->options([
                            'email' => __('translate.customer.options_cpreferences.0'),
                            'whatsapp' => __('translate.customer.options_cpreferences.1'),
                            'phone' => __('translate.customer.options_cpreferences.2'),
                            'other' => __('translate.customer.options_cpreferences.3')
                        ])
                        ,
                    Forms\Components\DatePicker::make('initial_contact_date')
                        ->label(__('translate.customer.initial_contact_date')),
                    Forms\Components\Select::make('customer_type')
                        ->label(__('translate.customer.customer_type'))
                        ->options([
                            'buyer' => __('translate.customer.options_cust_type.0'),
                            'seller' => __('translate.customer.options_cust_type.1'),
                            'investor' => __('translate.customer.options_cust_type.2'),
                            'tenant' => __('translate.customer.options_cust_type.3'),
                            'other' => __('translate.customer.options_cust_type.4')
                        ])
                        ,
                    Forms\Components\TextInput::make('budget')
                        ->label(__('translate.customer.budget'))
                        ->numeric(),
                    Forms\Components\TextInput::make('expected_commission')
                        ->label(__('translate.customer.expected_commission'))
                        ->numeric(),
                    Forms\Components\Textarea::make('address')
                        ->label(__('translate.customer.address')),
                    // Forms\Components\Textarea::make('credid_information')
                    //     ->columnSpanFull()
                    //     ,
                    Forms\Components\Toggle::make('financing')
                        ->label(__('translate.customer.financing')),
                ]),

                Section::make(__('resources.customer.sectionAgent'))
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label(__('translate.customer.user_id'))
                        ->relationship(name: 'user', titleAttribute: 'name')

                ])
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('translate.customer.user_id'))
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('user.state')
                    ->label(__('translate.user.state'))
                    ->alignCenter()
                    ->boolean(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('translate.customer.email'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('translate.customer.phone_number'))
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('translate.customer.address'))
                    ->searchable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact_preferences')
                    ->label(__('translate.customer.contact_preferences'))
                    ->alignCenter()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
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
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('customer_type')
                    ->label(__('translate.customer.customer_type'))
                    ->searchable()
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
                Tables\Columns\TextColumn::make('budget')
                    ->label(__('translate.customer.budget'))
                    ->alignCenter()
                    ->searchable(),
                Tables\Columns\TextColumn::make('expected_commission')
                    ->label(__('translate.customer.expected_commission'))
                    ->alignCenter()
                    ->searchable(),
                Tables\Columns\IconColumn::make('financing')
                    ->label(__('translate.customer.financing'))
                    ->alignCenter()
                    ->boolean(),
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
                //
            ])
            ->actions([
                CommentsAction::make()
                    ->color('info'),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
