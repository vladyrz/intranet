<?php

namespace App\Filament\Personal\Traits;

use App\Models\PropertyAssignment;
use Flowframe\Trend\Trend;
use Illuminate\Support\Facades\Auth;

trait PersonalAssignmentTrait
{
    protected function getChartData(): array
    {
        $userId = Auth::id();
        $statuses = ['pending', 'submitted', 'approved', 'rejected', 'published', 'assigned', 'finished'];
        $trendData = [];

        foreach ($statuses as $status) {
            $trendData[$status] = Trend::query(
                PropertyAssignment::where('user_id', $userId)
                    ->where('property_assignment_status', $status)
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
                'submitted' => $trendData['submitted']->firstWhere('date', $month)?->aggregate ?? 0,
                'approved' => $trendData['approved']->firstWhere('date', $month)?->aggregate ?? 0,
                'rejected' => $trendData['rejected']->firstWhere('date', $month)?->aggregate ?? 0,
                'published' => $trendData['published']->firstWhere('date', $month)?->aggregate ?? 0,
                'assigned' => $trendData['assigned']->firstWhere('date', $month)?->aggregate ?? 0,
                'finished' => $trendData['finished']->firstWhere('date', $month)?->aggregate ?? 0,
            ];
        }

        return $formattedData;
    }
}
