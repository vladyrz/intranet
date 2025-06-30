<?php

namespace App\Exports;

use App\Models\Offer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OffersPerUserExport implements FromView, ShouldAutoSize
{
    protected $month;
    protected $year;
    protected $week;

    public function __construct(?int $month = null, ?int $year = null, ?int $week = null)
    {
        $this->month = $month;
        $this->year = $year;
        $this->week = $week;
    }

    public function view(): View
    {
        $query = Offer::query()
            ->join('users', 'offers.user_id', '=', 'users.id')
            ->selectRaw('users.name as usuario, COUNT(offers.id) as total_ofertas')
            ->groupBy('users.name');

        if ($this->month) {
            $query->whereMonth('offers.created_at', $this->month);
        }

        if ($this->year) {
            $query->whereYear('offers.created_at', $this->year);
        }

        if ($this->week) {
            $query->whereRaw('WEEK(offers.created_at, 1) = ?', [$this->week]);
        }

        $ofertas = $query->get();

        return view('exports.offers_per_user', [
            'ofertas' => $ofertas,
            'mes' => $this->month,
            'anio' => $this->year,
            'semana' => $this->week,
        ]);
    }
}
