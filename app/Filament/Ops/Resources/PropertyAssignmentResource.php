<?php

namespace App\Filament\Ops\Resources;

use App\Filament\Ops\Resources\PropertyAssignmentResource\Pages;
use App\Filament\Ops\Resources\PropertyAssignmentResource\RelationManagers;
use App\Models\Organization;
use App\Models\PropertyAssignment;
use App\Models\User;
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
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class PropertyAssignmentResource extends Resource
{
    protected static ?string $model = PropertyAssignment::class;

    protected static ?int $navigationSort = 4;

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
        return __('resources.employee.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.property_assignment.sectionMainInfo'))
                    ->columns(3)
                    ->schema([
                        Select::make('user_id')
                            ->label(__('translate.property_assignment.user_id'))
                            ->searchable()
                            ->preload()
                            ->options(
                                User::all()
                                ->pluck('name', 'id')
                            ),
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
                            ->maxFiles(10)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('translate.property_assignment.user_id'))
                    ->searchable()
                    ->alignCenter(),
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
                    ->alignCenter()
                    ->badge()
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
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'submitted' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'published' => 'info',
                        'assigned' => 'info',
                        'finished' => 'info',
                    }),
                TextColumn::make('created_at')
                    ->label(__('translate.property_assignment.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.property_assignment.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('organization_id')
                    ->label(__('translate.property_assignment.organization_id'))
                    ->searchable()
                    ->relationship(
                        name: 'organization',
                        titleAttribute: 'organization_name',
                    )
                    ->preload(),
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
            'index' => Pages\ListPropertyAssignments::route('/'),
            'create' => Pages\CreatePropertyAssignment::route('/create'),
            'edit' => Pages\EditPropertyAssignment::route('/{record}/edit'),
        ];
    }
}
