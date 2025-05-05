<?php

namespace App\Filament\Rrhh\Resources;

use App\Filament\Rrhh\Resources\BillingControlResource\Pages;
use App\Filament\Rrhh\Resources\BillingControlResource\RelationManagers;
use App\Models\BillingControl;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class BillingControlResource extends Resource
{
    protected static ?string $model = BillingControl::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getLabel(): ?string
    {
        return __('resources.billing_control.label');
    }

    public static function getPluralLabel(): ?string
    {
        return __('resources.billing_control.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.billing_control.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.employee_checklist.navigation_group');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('resources.billing_control.sectionBillingControl'))
                    ->columns(2)
                    ->schema([
                        Select::make('offer_id')
                            ->label(__('translate.billing_control.offer_id'))
                            ->relationship(
                                name: 'offer',
                                titleAttribute: 'property_name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('offer_status', 'signed'),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('invoice_status')
                            ->label(__('translate.billing_control.invoice_status'))
                            ->options(__('translate.billing_control.options_invoice_status'))
                            ->required(),
                        TextInput::make('payment_percentage')
                            ->label(__('translate.billing_control.payment_percentage'))
                            ->maxLength(5)
                            ->suffix('%')
                            ->required(),
                        DatePicker::make('billing_date')
                            ->label(__('translate.billing_control.billing_date'))
                            ->required(),
                        FileUpload::make('invoice_files')
                            ->label(__('translate.billing_control.invoice_files'))
                            ->multiple()
                            ->columnSpanFull()
                            ->downloadable()
                            ->directory('facturas/' .now()->format('Y/m/d'))
                            ->maxFiles(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('offer.property_name')
                    ->label(__('translate.billing_control.offer_id'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('offer.personal_customer.full_name')
                    ->label(__('translate.offer.personal_customer_id'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('invoice_status')
                    ->label(__('translate.billing_control.invoice_status'))
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(
                        fn($state) => __('translate.billing_control.options_invoice_status.' . $state)
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'invoiced' => 'info',
                        'paid' => 'success',
                    }),
                TextColumn::make('payment_percentage')
                    ->label(__('translate.billing_control.payment_percentage'))
                    ->formatStateUsing(fn($state) => $state . '%')
                    ->alignCenter(),
                TextColumn::make('offer.user.name')
                    ->label(__('translate.offer.user_id'))
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('billing_date')
                    ->label(__('translate.billing_control.billing_date'))
                    ->date()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->label(__('translate.billing_control.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('translate.billing_control.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('invoice_status')
                    ->label(__('translate.billing_control.invoice_status'))
                    ->options(__('translate.billing_control.options_invoice_status')),
            ])
            ->actions([
                ActionGroup::make([
                    CommentsAction::make()
                        ->color('info'),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make()
                        ->color('danger'),
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
            'index' => Pages\ListBillingControls::route('/'),
            'create' => Pages\CreateBillingControl::route('/create'),
            'edit' => Pages\EditBillingControl::route('/{record}/edit'),
        ];
    }
}
