<?php

namespace App\Filament\Personal\Resources;

use App\Filament\Personal\Resources\CollaborationRequestResource\Pages;
use App\Filament\Personal\Resources\CollaborationRequestResource\RelationManagers;
use App\Models\{CollaborationRequest, PersonalCustomer};
use Filament\Forms;
use Filament\Forms\Components\{Section, Textarea, TextInput, Select};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class CollaborationRequestResource extends Resource
{
    protected static ?string $model = CollaborationRequest::class;
    protected static ?string $navigationGroup = null;
    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $modelLabel = 'colaboración';
    protected static ?string $pluralModelLabel = 'colaboraciones';

    public static function getNavigationGroup(): ?string
    {
        return __('resources.customer.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del cliente')
                    ->columns(2)
                    ->schema([
                        Select::make('personal_customer_id')->label('Cliente')->options(
                            fn() =>
                            PersonalCustomer::query()
                                ->where('user_id', Auth::user()->id)
                                ->orderBy('id', 'desc')
                                ->limit(500)
                                ->pluck('full_name', 'id')
                        )->searchable()->preload()->required(),

                        TextInput::make('client_budget')->label('Presupuesto del cliente')->numeric()->suffix('₡')->minValue(0)->default(0),

                        Textarea::make('areas_of_interest')->label('Zona o zonas de interés')->rows(3),

                        Textarea::make('search_details')->label('Detalles de búsqueda (tipo de propiedad, tamaño, condiciones, etc.)')->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('personal_customer.full_name')->label('Cliente')->searchable()->toggleable(),
                TextColumn::make('client_budget')->label('Presupuesto')->money('CRC', true)->toggleable(),
                TextColumn::make('areas_of_interest')->label('Zonas de interés')->toggleable(),
                TextColumn::make('search_details')->label('Detalles de búsqueda')->toggleable(),
                TextColumn::make('created_at')->label('Creado')->dateTime()->since()->toggleable(),
                TextColumn::make('updated_at')->label('Actualizado')->dateTime()->since()->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()->color('info'),
                    Tables\Actions\EditAction::make()->color('warning'),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::user()->id);
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
            'index' => Pages\ListCollaborationRequests::route('/'),
            'create' => Pages\CreateCollaborationRequest::route('/create'),
            'edit' => Pages\EditCollaborationRequest::route('/{record}/edit'),
        ];
    }
}
