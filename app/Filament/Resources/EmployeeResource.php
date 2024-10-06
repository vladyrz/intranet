<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\City;
use App\Models\Employee;
use App\Models\State;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.employee.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.employee.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.employee.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.user.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.employee.sectionEmployee'))
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('translate.employee.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label(__('translate.employee.email'))
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('job_position')
                        ->label(__('translate.employee.job_position'))
                        ->options([
                            'Administrativo' => 'Administrativo',
                            'Gerente de Ventas' => 'Gerente de Ventas',
                            'Asesor de Ventas' => 'Asesor de Ventas',
                        ]),
                    Forms\Components\Select::make('progress_status')
                        ->label(__('translate.employee.progress_status'))
                        ->options([
                            'Pendiente' => 'Pendiente',
                            'En Formación' => 'En Formación',
                            'Certificado' => 'Certificado',
                            'Retirado' => 'Retirado',
                        ])
                        ->required(),
                    Forms\Components\Toggle::make('contract_status')
                        ->label(__('translate.employee.contract_status'))
                        ->required(),
                ]),

                Section::make(__('resources.employee.sectionPersonal'))
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('personal_email')
                        ->label(__('translate.employee.personal_email'))
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('national_id')
                        ->label(__('translate.employee.national_id'))
                        ->maxLength(15),
                    Forms\Components\Select::make('marital_status')
                        ->label(__('translate.employee.marital_status'))
                        ->options([
                            'Soltero/a' => 'Soltero/a',
                            'Casado/a' => 'Casado/a',
                            'Divorciado/a' => 'Divorciado/a',
                            'Viudo/a' => 'Viudo/a',
                            'Unión Libre' => 'Unión Libre'
                        ]),
                    Forms\Components\TextInput::make('profession')
                        ->label(__('translate.employee.profession')),
                    Forms\Components\TextInput::make('phone_number')
                        ->label(__('translate.employee.phone_number'))
                        ->maxLength(15),
                    Forms\Components\TextInput::make('license_plate')
                        ->label(__('translate.employee.license_plate')),
                    Forms\Components\DatePicker::make('birthday')
                        ->label(__('translate.employee.birthday')),
                ]),

                Section::make(__('resources.employee.sectionAddress'))
                ->columns(3)
                ->schema([
                    // ...
                    Forms\Components\Select::make('country_id')
                        ->label(__('translate.employee.country'))
                        ->relationship(name: 'country', titleAttribute:'name')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set){
                            $set('state_id', null);
                            $set('city_id', null);
                        }),
                    Forms\Components\Select::make('state_id')
                        ->label(__('translate.employee.locationState'))
                        ->options(fn (Get $get): Collection => State::query()
                            ->where('country_id', $get('country_id'))
                            ->pluck('name', 'id')
                        )
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set){
                            $set('city_id', null);
                        }),                    
                    Forms\Components\Select::make('city_id')
                        ->label(__('translate.employee.locationCity'))
                        ->options(fn (Get $get): Collection => City::query()
                            ->where('state_id', $get('state_id'))
                            ->pluck('name', 'id')
                        )
                        ->searchable()
                        ->preload(),
                    Forms\Components\Textarea::make('address')
                        ->label(__('translate.employee.address'))
                        ->columnSpanFull(),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('translate.employee.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('translate.employee.email'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('contract_status')
                    ->label(__('translate.employee.contract_status'))
                    ->boolean()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('progress_status')
                    ->label(__('translate.employee.progress_status'))
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
                    ->label(__('translate.employee.job_position'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('national_id')
                    ->label(__('translate.employee.national_id'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('translate.employee.phone_number'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('personal_email')
                    ->label(__('translate.employee.personal_email'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('profession')
                    ->label(__('translate.employee.profession'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->label(__('translate.employee.license_plate'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('country.name')
                    ->label(__('translate.employee.country'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('locationState.name')
                    ->label(__('translate.employee.locationState'))
                    ->alignCenter()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('locationCity.name')
                    ->label(__('translate.employee.locationCity'))
                    ->alignCenter()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('translate.employee.address'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('birthday')
                    ->label(__('translate.employee.birthday'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('marital_status')
                    ->label(__('translate.employee.marital_status'))
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault:true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('translate.employee.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('translate.employee.updated_at'))
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
