<?php

namespace App\Filament\Personal\Traits;

use App\Models\Offer;
use Flowframe\Trend\Trend;
use Illuminate\Support\Facades\Auth;

trait PersonalOfferTrait
{
    protected function getChartData(): array
    {
        $userId = Auth::id();

        $statuses = ['pending', 'sent', 'approved', 'rejected', 'signed'];
        $trendData = [];

        foreach ($statuses as $status) {
            $trendData[$status] = Trend::query(
                Offer::where('user_id', $userId)
                    ->where('offer_status', $status)
            )
                ->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear()
                )
                ->perMonth()
                ->count();
        }

        $formattedData = [];
        foreach ($trendData[array_key_first($trendData)] as $trendValue) {
            $month = $trendValue->date;
            $formattedData[$month] = [
                'pending' => $trendData['pending']->firstWhere('date', $month)?->aggregate ?? 0,
                'sent' => $trendData['sent']->firstWhere('date', $month)?->aggregate ?? 0,
                'approved' => $trendData['approved']->firstWhere('date', $month)?->aggregate ?? 0,
                'rejected' => $trendData['rejected']->firstWhere('date', $month)?->aggregate ?? 0,
                'signed' => $trendData['signed']->firstWhere('date', $month)?->aggregate ?? 0,
            ];
        }

        return $formattedData;
    }
}
