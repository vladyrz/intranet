<?php

namespace App\Filament\Personal\Resources;

use App\Filament\Personal\Resources\PropertyAssignmentResource\Pages;
use App\Filament\Personal\Resources\PropertyAssignmentResource\RelationManagers;
use App\Models\Organization;
use App\Models\PropertyAssignment;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class PropertyAssignmentResource extends Resource
{
    protected static ?string $model = PropertyAssignment::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.property_assignment.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.property_assignment.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.property_assignment.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.customer.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

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
                Section::make(__('resources.property_assignment.sectionMainInfo'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('property_info')
                            ->label(__('translate.property_assignment.property_info')),
                        Select::make('organization_id')
                            ->label(__('translate.property_assignment.organization_id'))
                            ->searchable()
                            ->preload()
                            ->options(
                                Organization::all()
                                ->pluck('organization_name', 'id')
                            ),
                        Textarea::make('property_observations')
                            ->label(__('translate.property_assignment.property_observations'))
                            ->columnSpanFull(),
                    ]),

                Section::make(__('resources.property_assignment.sectionImages'))
                    ->schema([
                        FileUpload::make('property_images')
                            ->label(__('translate.property_assignment.property_images'))
                            ->multiple()
                            ->image()
                            ->directory('property_assignments/' .now()->format('Y/m/d'))
                            ->downloadable()
                            ->minFiles(1)
                            ->maxFiles(5)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('property_info')
                    ->label(__('translate.property_assignment.property_info'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('organization.organization_name')
                    ->label(__('translate.property_assignment.organization_id'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('property_observations')
                    ->label(__('translate.property_assignment.property_observations'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('property_assignment_status')
                    ->label(__('translate.property_assignment.property_assignment_status'))
                    ->searchable()
                    ->alignCenter()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'pending' => __('translate.property_assignment.options_property_assignment_status.0'),
                            'submitted' => __('translate.property_assignment.options_property_assignment_status.1'),
                            'approved' => __('translate.property_assignment.options_property_assignment_status.2'),
                            'rejected' => __('translate.property_assignment.options_property_assignment_status.3'),
                            'published' => __('translate.property_assignment.options_property_assignment_status.4'),
                            'assigned' => __('translate.property_assignment.options_property_assignment_status.5'),
                            'finished' => __('translate.property_assignment.options_property_assignment_status.6'),
                        };
                    }),
                TextColumn::make('created_at')
                    ->label(__('translate.property_assignment.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('translate.property_assignment.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('organization_id')
                    ->label(__('translate.property_assignment.organization_id'))
                    ->searchable()
                    ->preload()
                    ->relationship(
                        name: 'organization',
                        titleAttribute: 'organization_name'
                    ),
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
            'index' => Pages\ListPropertyAssignments::route('/'),
            'create' => Pages\CreatePropertyAssignment::route('/create'),
            'edit' => Pages\EditPropertyAssignment::route('/{record}/edit'),
        ];
    }
}
