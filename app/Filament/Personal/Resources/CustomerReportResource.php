<?php

namespace App\Filament\Personal\Resources;

use App\Filament\Personal\Resources\CustomerReportResource\Pages;
use App\Filament\Personal\Resources\CustomerReportResource\RelationManagers;
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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
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
        return __('resources.customer.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        $lockedStatuses = ['received', 'approved', 'rejected'];

        $isLocked = function (Get $get, ?Model $record) use ($lockedStatuses): bool {
            $status = $get('report_status') ?? $record->report_status;

            return in_array($status, $lockedStatuses, true);
        };

        $lock = fn($component) => $component
            ->disabled($isLocked)
            ->dehydrated(fn(Get $get, ?Model $record) => ! $isLocked($get, $record));

        return $form
            ->schema([
                Section::make(__('resources.customer_report.section_customer'))
                    ->columns(3)
                    ->schema([
                        $lock(Select::make('personal_customer_id')->label(__('translate.customer_report.personal_customer_id'))->options(
                            PersonalCustomer::query()
                                ->where('user_id', Auth::user()->id)
                                ->pluck('full_name', 'id')
                        )->searchable()->preload()->required()),
                        $lock(TextInput::make('property_name')->label(__('translate.customer_report.property_name'))->maxLength(255)->required()),
                        $lock(Select::make('organization_id')->label(__('translate.customer_report.organization_id'))->relationship(
                            name: 'organization',
                            titleAttribute: 'organization_name',
                        )->preload()->searchable()->required()),
                        $lock(Textarea::make('user_comments')->label(__('translate.access_request.user_comments'))),
                        Select::make('report_status')
                            ->label(__('translate.customer_report.report_status'))
                            ->options([
                                'pending' => __('translate.customer_report.options_report_status.0'),
                                'received' => __('translate.customer_report.options_report_status.1'),
                                'approved' => __('translate.customer_report.options_report_status.2'),
                                'rejected' => __('translate.customer_report.options_report_status.3'),
                            ])
                            ->live()
                            ->required()
                            ->disabled()
                            ->default('pending'),
                        Textarea::make('rejection_reason')
                            ->label(__('translate.offer.rejection_reason'))
                            ->visible(fn(Get $get): bool => $get('report_status') == 'rejected')
                            ->disabled(),
                    ]),

                Section::make(__('resources.customer_report.section_financial'))
                    ->columns(2)
                    ->schema([
                        $lock(TextInput::make('budget_usd')->label(__('translate.customer_report.budget_usd'))->numeric()),
                        $lock(TextInput::make('budget_crc')->label(__('translate.customer_report.budget_crc'))->numeric()),
                        $lock(TextInput::make('expected_commission_usd')->label(__('translate.customer_report.expected_commission_usd'))->numeric()),
                        $lock(TextInput::make('expected_commission_crc')->label(__('translate.customer_report.expected_commission_crc'))->numeric()),
                        $lock(Toggle::make('financing')->label(__('translate.customer_report.financing'))),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('personal_customer.full_name')
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
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'pending' => __('translate.customer_report.options_report_status.0'),
                            'received' => __('translate.customer_report.options_report_status.1'),
                            'approved' => __('translate.customer_report.options_report_status.2'),
                            'rejected' => __('translate.customer_report.options_report_status.3'),
                        };
                    })
                    ->color(fn(string $state): string => match ($state) {
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
                ])
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
