<?php

namespace App\Exports;

use App\Models\AccesRequest;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RequestPerUserExport implements FromView, ShouldAutoSize
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
        $query = AccesRequest::query()
            ->join('users', 'acces_requests.user_id', '=', 'users.id')
            ->selectRaw('users.name as usuario, COUNT(acces_requests.id) as total_solicitudes')
            ->groupBy('users.name');

        if ($this->month) {
            $query->whereMonth('acces_requests.created_at', $this->month);
        }

        if ($this->year) {
            $query->whereYear('acces_requests.created_at', $this->year);
        }

        if ($this->week) {
            $query->whereRaw('WEEK(acces_requests.created_at, 1) = ?', [$this->week]);
        }

        $solicitudes = $query->get();

        return view('exports.requests_per_user', [
            'solicitudes' => $solicitudes,
            'mes' => $this->month,
            'anio' => $this->year,
            'semana' => $this->week,
        ]);
    }
}
