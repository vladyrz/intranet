<?php

namespace App\Filament\Ops\Resources;

use App\Filament\Ops\Resources\CustomerReportResource\Pages;
use App\Filament\Ops\Resources\CustomerReportResource\RelationManagers;
use App\Models\CustomerReport;
use App\Models\PersonalCustomer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;

class CustomerReportResource extends Resource
{
    protected static ?string $model = CustomerReport::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.customer_report.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.customer_report.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.customer_report.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.employee.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.customer_report.section_customer'))
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label(__('translate.customer_report.user_id'))
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name',
                            )
                            ->preload()
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set){
                                $set('personal_customer_id', null);
                            }),
                        Select::make('personal_customer_id')
                            ->label(__('translate.customer_report.personal_customer_id'))
                            ->options(fn (Get $get): Collection => PersonalCustomer::query()
                                ->where('user_id', $get('user_id'))
                                ->pluck('full_name', 'id')
                            ),
                        TextInput::make('property_name')
                            ->label(__('translate.customer_report.property_name'))
                            ->maxLength(255),
                        Select::make('organization_id')
                            ->label(__('translate.customer_report.organization_id'))
                            ->relationship(
                                name: 'organization',
                                titleAttribute: 'organization_name',
                            )
                            ->preload()
                            ->searchable()
                            ->required(),
                        Select::make('report_status')
                            ->label(__('translate.customer_report.report_status'))
                            ->options([
                                'pending' => __('translate.customer_report.options_report_status.0'),
                                'received' => __('translate.customer_report.options_report_status.1'),
                                'approved' => __('translate.customer_report.options_report_status.2'),
                                'rejected' => __('translate.customer_report.options_report_status.3'),
                            ])
                            ->reactive()
                            ->required(),
                        Textarea::make('rejection_reason')
                            ->label(__('translate.offer.rejection_reason'))
                            ->visible(fn (Get $get): bool => $get('report_status') == 'rejected'),
                    ]),

                Section::make(__('resources.customer_report.section_financial'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('budget_usd')
                            ->label(__('translate.customer_report.budget_usd'))
                            ->numeric(),
                        TextInput::make('budget_crc')
                            ->label(__('translate.customer_report.budget_crc'))
                            ->numeric(),
                        TextInput::make('expected_commission_usd')
                            ->label(__('translate.customer_report.expected_commission_usd'))
                            ->numeric(),
                        TextInput::make('expected_commission_crc')
                            ->label(__('translate.customer_report.expected_commission_crc'))
                            ->numeric(),
                        Toggle::make('financing')
                            ->label(__('translate.customer_report.financing')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('translate.customer_report.user_id'))
                    ->searchable()
                    ->alignLeft(),
                TextColumn::make('peronal_customer.full_name')
                    ->label(__('translate.customer_report.personal_customer_id'))
                    ->searchable()
                    ->alignLeft(),
                TextColumn::make('personal_customer.national_id')
                    ->label(__('translate.customer_report.national_id'))
                    ->searchable()
                    ->alignRight()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('personal_customer.email')
                    ->label(__('translate.customer_report.email'))
                    ->alignLeft()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('personal_customer.phone_number')
                    ->label(__('translate.customer_report.phone_number'))
                    ->alignRight()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('property_name')
                    ->label(__('translate.customer_report.property_name'))
                    ->alignLeft()
                    ->searchable(),
                TextColumn::make('organization.organization_name')
                    ->label(__('translate.customer_report.organization_id'))
                    ->alignLeft()
                    ->searchable(),
                TextColumn::make('budget_usd')
                    ->label(__('translate.customer_report.budget_usd'))
                    ->alignRight()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('budget_crc')
                    ->label(__('translate.customer_report.budget_crc'))
                    ->alignRight()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('expected_commission_usd')
                    ->label(__('translate.customer_report.expected_commission_usd'))
                    ->alignRight()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('expected_commission_crc')
                    ->label(__('translate.customer_report.expected_commission_crc'))
                    ->alignRight()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                IconColumn::make('financing')
                    ->label(__('translate.customer_report.financing'))
                    ->alignCenter()
                    ->boolean(),
                TextColumn::make('report_status')
                    ->label(__('translate.customer_report.report_status'))
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(function ($state){
                        return match ($state) {
                            'pending' => __('translate.customer_report.options_report_status.0'),
                            'received' => __('translate.customer_report.options_report_status.1'),
                            'approved' => __('translate.customer_report.options_report_status.2'),
                            'rejected' => __('translate.customer_report.options_report_status.3'),
                        };
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'received' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                TextColumn::make('rejection_reason')
                    ->label(__('translate.offer.rejection_reason'))
                    ->alignLeft()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('translate.customer_report.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.customer_report.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('organization_id')
                    ->label(__('translate.customer_report.organization_id'))
                    ->relationship(
                        name: 'organization',
                        titleAttribute: 'organization_name',
                    )
                    ->searchable(),
            ])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()
                        ->color('info'),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make()
                ]),
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
            'index' => Pages\ListCustomerReports::route('/'),
            'create' => Pages\CreateCustomerReport::route('/create'),
            'edit' => Pages\EditCustomerReport::route('/{record}/edit'),
        ];
    }
}
