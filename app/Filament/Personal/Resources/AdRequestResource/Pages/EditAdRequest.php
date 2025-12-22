<?php

namespace App\Filament\Personal\Resources\AdRequestResource\Pages;

use App\Filament\Personal\Resources\AdRequestResource;
use App\Models\AdRequest;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditAdRequest extends EditRecord
{
    protected static string $resource = AdRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            Action::make('payWithStripe')
                ->label('Pagar con TC/TD')
                ->icon('heroicon-m-credit-card')
                ->color('success')
                ->url(fn(AdRequest $record) => route('ad-requests.pay', $record))
                ->openUrlInNewTab()
                ->visible(fn(AdRequest $record) => $record->investment_amount > 0 && $record->stripe_payment_status !== 'paid'),
        ];
    }
}
