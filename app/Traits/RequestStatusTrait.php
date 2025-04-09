<?php

namespace App\Traits;

use App\Models\AccesRequest;
use Flowframe\Trend\Trend;

trait RequestStatusTrait
{
    protected function getChartData(): array
    {
        $statuses = ['pending', 'sent', 'approved', 'rejected'];
        $trendData = [];

        foreach ($statuses as $status) {
            $trendData[$status] = Trend::query(
                AccesRequest::where('request_status', $status)
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
            ];
        }

        return $formattedData;
    }
}
