<?php

namespace App\Filament\Ops\Resources;

use App\Filament\Ops\Resources\EmployeeChecklistResource\Pages;
use App\Filament\Ops\Resources\EmployeeChecklistResource\RelationManagers;
use App\Models\EmployeeChecklist;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class EmployeeChecklistResource extends Resource
{
    protected static ?string $model = EmployeeChecklist::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.employee_checklist.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.employee_checklist.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.employee_checklist.navigation');
    }

    public static function getNavigationGroup(): string
    {
        return __('resources.employee.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(3)
                    ->schema([
                        Select::make('employee_id')
                            ->label(__('translate.employee_checklist.employee_id'))
                            ->relationship(
                                name: 'employee',
                                titleAttribute: 'name',
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('task')
                            ->label(__('translate.employee_checklist.task'))
                            ->options(__('translate.employee_checklist.options_task'))
                            ->required(),
                        Select::make('easypro_email')
                            ->label(__('translate.employee_checklist.easypro_email'))
                            ->options([
                                'si' => 'Si',
                                'no' => 'No',
                            ])
                            ->required(),
                        Select::make('easyu_user')
                            ->label(__('translate.employee_checklist.easyu_user'))
                            ->options([
                                'si' => 'Si',
                                'no' => 'No',
                            ])
                            ->required(),
                        Select::make('bienes_adjudicados_user')
                            ->label(__('translate.employee_checklist.bienes_adjudicados_user'))
                            ->options([
                                'si' => 'Si',
                                'no' => 'No',
                            ])
                            ->required(),
                        Select::make('intranet_user')
                            ->label(__('translate.employee_checklist.intranet_user'))
                            ->options([
                                'si' => 'Si',
                                'no' => 'No',
                            ])
                            ->required(),
                        Select::make('email_marketing_group')
                            ->label(__('translate.employee_checklist.email_marketing_group'))
                            ->options([
                                'si' => 'Si',
                                'no' => 'No',
                                'n/a' => 'N/A',
                            ])
                            ->required(),
                        Select::make('phone_extension')
                            ->label(__('translate.employee_checklist.phone_extension'))
                            ->options([
                                'si' => 'Si',
                                'no' => 'No',
                                'n/a' => 'N/A',
                            ])
                            ->required(),
                        Select::make('social_networks')
                            ->label(__('translate.employee_checklist.social_networks'))
                            ->options([
                                'si' => 'Si',
                                'no' => 'No',
                                'n/a' => 'N/A',
                            ])
                            ->required(),
                        Select::make('nas_access')
                            ->label(__('translate.employee_checklist.nas_access'))
                            ->options([
                                'si' => 'Si',
                                'no' => 'No',
                                'n/a' => 'N/A',
                            ])
                            ->required(),
                        Select::make('email_signature_card')
                            ->label(__('translate.employee_checklist.email_signature_card'))
                            ->options([
                                'si' => 'Si',
                                'no' => 'No',
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label(__('translate.employee_checklist.employee_id'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('task')
                    ->label(__('translate.employee_checklist.task'))
                    ->alignCenter()
                    ->formatStateUsing(
                        fn($state) => __('translate.employee_checklist.options_task.' . $state)
                    )
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'included' => 'success',
                        'excluded' => 'danger',
                    }),
                TextColumn::make('easypro_email')
                    ->label(__('translate.employee_checklist.easypro_email'))
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'si' => 'success',
                        'no' => 'danger',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('easyu_user')
                    ->label(__('translate.employee_checklist.easyu_user'))
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'si' => 'success',
                        'no' => 'danger',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('bienes_adjudicados_user')
                    ->label(__('translate.employee_checklist.bienes_adjudicados_user'))
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'si' => 'success',
                        'no' => 'danger',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('intranet_user')
                    ->label(__('translate.employee_checklist.intranet_user'))
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'si' => 'success',
                        'no' => 'danger',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('email_marketing_group')
                    ->label(__('translate.employee_checklist.email_marketing_group'))
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'si' => 'success',
                        'no' => 'danger',
                        'n/a' => 'warning',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('phone_extension')
                    ->label(__('translate.employee_checklist.phone_extension'))
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'si' => 'success',
                        'no' => 'danger',
                        'n/a' => 'warning',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('social_networks')
                    ->label(__('translate.employee_checklist.social_networks'))
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'si' => 'success',
                        'no' => 'danger',
                        'n/a' => 'warning',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('nas_access')
                    ->label(__('translate.employee_checklist.nas_access'))
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'si' => 'success',
                        'no' => 'danger',
                        'n/a' => 'warning',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('email_signature_card')
                    ->label(__('translate.employee_checklist.email_signature_card'))
                    ->alignCenter()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'si' => 'success',
                        'no' => 'danger',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->label(__('translate.employee_checklist.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.employee_checklist.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('task')
                    ->label(__('translate.employee_checklist.task'))
                    ->options(__('translate.employee_checklist.options_task')),
            ])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()
                        ->color('info'),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListEmployeeChecklists::route('/'),
            'create' => Pages\CreateEmployeeChecklist::route('/create'),
            'edit' => Pages\EditEmployeeChecklist::route('/{record}/edit'),
        ];
    }
}
