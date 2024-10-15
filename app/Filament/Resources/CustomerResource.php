<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('resources.employee.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Customer Info')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('full_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone_number')
                        ->required()
                        ->maxLength(20),
                    Forms\Components\Select::make('contact_preferences')
                        ->options([
                            'Email' => 'Email',
                            'Phone' => 'Phone',
                            'WhatsApp' => 'WhatsApp',
                            'Other' => 'Other',
                        ])
                        ->required(),
                    Forms\Components\DatePicker::make('initial_contact_date')
                        ->required(),
                    Forms\Components\Select::make('customer_type')
                        ->options([
                            'Buyer' => 'Buyer',
                            'Seller' => 'Seller',
                            'Investor' => 'Investor',
                            'Tenant' => 'Tenant',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('budget')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('expected_commission')
                        ->numeric()
                        ->required(),
                    Forms\Components\Textarea::make('address')
                        ->required(),
                    Forms\Components\Textarea::make('interaction_notes')
                        ->columnSpanFull()
                        ->required(),
                    // Forms\Components\Textarea::make('credid_information')
                    //     ->columnSpanFull()
                    //     ->required(),
                    Forms\Components\Textarea::make('internal_notes')
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\Toggle::make('financing')
                        ->required(),
                ]),

                Section::make('Agent Info')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship(name: 'user', titleAttribute: 'name')
                        ->required()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('user.state')
                    ->label('User State')
                    ->alignCenter()
                    ->boolean(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('contact_preferences')
                    ->searchable(),
                Tables\Columns\TextColumn::make('initial_contact_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('interaction_notes')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('credid_information')
                //     ->searchable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('budget')
                    ->searchable(),
                Tables\Columns\IconColumn::make('financing')
                    ->boolean(),
                Tables\Columns\TextColumn::make('expected_commission')
                    ->searchable(),
                Tables\Columns\TextColumn::make('internal_notes')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
