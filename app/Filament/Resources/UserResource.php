<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\FormsComponent;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Collection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    // protected static ?string $navigationLabel = 'Employees';

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.user.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.user.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.user.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.user.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 4;
    // protected static ?string $modelLabel = 'usuario';
    // protected static ?string $pluralModelLabel = 'Usuarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Info')
                ->columns(3)
                ->schema([
                    // ...
                    Forms\Components\TextInput::make('name')
                        ->label(__('translate.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label(__('translate.email'))
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->label(__('translate.password'))
                        ->password()
                        ->hiddenOn('edit')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('email_verified_at')
                        ->label(__('translate.email_verified_at')),                    
                    Forms\Components\Select::make('job_position')
                        ->label(__('translate.job_position'))
                        ->options([
                            'Administrativo' => 'Administrativo',
                            'Gerente de Ventas' => 'Gerente de Ventas',
                            'Asesor de Ventas' => 'Asesor de Ventas',
                        ]),
                    Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('progress_status')
                        ->label(__('translate.progress_status'))
                        ->options([
                            'Pendiente' => 'Pendiente',
                            'En Formación' => 'En Formación',
                            'Certificado' => 'Certificado',
                            'Retirado' => 'Retirado',
                        ]),
                    Forms\Components\Toggle::make('contract_status')
                        ->label(__('translate.contract_status'))
                        ->required(),
                    Forms\Components\Toggle::make('state')
                        ->label(__('translate.state'))
                        ->required(),
                ]),

                Section::make('Personal Info')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('personal_email')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('national_id')
                        ->maxLength(15),
                    Forms\Components\Select::make('marital_status')
                        ->options([
                            'Soltero/a' => 'Soltero/a',
                            'Casado/a' => 'Casado/a',
                            'Divorciado/a' => 'Divorciado/a',
                            'Viudo/a' => 'Viudo/a',
                            'Unión Libre' => 'Unión Libre'
                        ]),
                    Forms\Components\TextInput::make('profession'),
                    Forms\Components\TextInput::make('phone_number')
                        ->maxLength(15),
                    Forms\Components\TextInput::make('license_plate'),
                    Forms\Components\DatePicker::make('birthday'),
                ]),

                Section::make('Address Info')
                ->columns(3)
                ->schema([
                    // ...
                    Forms\Components\Select::make('country_id')
                    ->relationship(name: 'country', titleAttribute:'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set){
                        $set('state_id', null);
                        $set('city_id', null);
                    })
                    ->required(),
                    Forms\Components\Select::make('state_id')
                    ->label('State')
                    ->options(fn (Get $get): Collection => State::query()
                        ->where('country_id', $get('country_id'))
                        ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set){
                        $set('city_id', null);
                    })
                    ->required(),                    
                    Forms\Components\Select::make('city_id')
                    ->label('City')
                    ->options(fn (Get $get): Collection => City::query()
                        ->where('state_id', $get('state_id'))
                        ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                    Forms\Components\Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('translate.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('translate.email'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('state')
                    ->label(__('translate.state'))
                    ->boolean()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('contract_status')
                    ->label(__('translate.contract_status'))
                    ->boolean()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'info',
                        'panel_user' => 'warning',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('progress_status')
                    ->label(__('translate.progress_status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'warning',
                        'En Formación' => 'info',
                        'Certificado' => 'success',
                        'Retirado' => 'danger',
                    })
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('job_position')
                    ->label(__('translate.job_position'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('national_id')
                    ->label(__('translate.national_id'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('translate.phone_number'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('personal_email')
                    ->label(__('translate.personal_email'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('profession')
                    ->label(__('translate.profession'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->label(__('translate.license_plate'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('country.name')
                    ->label(__('translate.country'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('locationState.name')
                    ->label(__('translate.locationState'))
                    ->alignCenter()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('locationCity.name')
                    ->label(__('translate.locationCity'))
                    ->alignCenter()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('translate.address'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('birthday')
                    ->label(__('translate.birthday'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('marital_status')
                    ->label(__('translate.marital_status'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault:true),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('translate.email_verified_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('translate.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('translate.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('job_position')
                    ->options([
                        'Administrativo' => 'Administrativo',
                        'Gerente de Ventas' => 'Gerente de Ventas',
                        'Asesor de Ventas' => 'Asesor de Ventas',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
