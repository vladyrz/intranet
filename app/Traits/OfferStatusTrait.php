<?php

namespace App\Traits;

use App\Models\Offer;

trait OfferStatusTrait
{
    protected function getChartData(): array
    {
        return Offer::selectRaw("
            DATE_FORMAT(created_at, '%Y-%m') as month,
                SUM(CASE WHEN offer_status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN offer_status = 'sent' THEN 1 ELSE 0 END) as sent,
                SUM(CASE WHEN offer_status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN offer_status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN offer_status = 'signed' THEN 1 ELSE 0 END) as signed
        ")
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month')
        ->toArray();
    }
}
