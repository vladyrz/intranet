<?php

namespace App\Filament\Personal\Widgets;

use App\Filament\Personal\Traits\PersonalRequesTrait;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ApexPersonalRequestStatus extends ApexChartWidget
{

    use PersonalRequesTrait;

    public static ?int $sort = 4;

    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'apexPersonalRequestStatus';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Cantidad de solicitudes de permiso';

    protected int|string|array $columnSpan = 'full';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {

        $chartData = $this->getChartData();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 450,
                'width' => '100%',
                'stacked' => true,
            ],
            'legend' => [
                'position' => 'top',
                'horizontalAlign' => 'center',
                'fontFamily' => 'inherit'
            ],
            'series' => [
                [
                    'name' => __('resources.acces_request.tab_pending'),
                    'data' => array_column($chartData, 'pending'),
                    'color' => '#facc15',
                ],
                [
                    'name' => __('resources.acces_request.tab_sent'),
                    'data' => array_column($chartData, 'sent'),
                    'color' => '#3b82f6',
                ],
                [   'name' => __('resources.acces_request.tab_approved'),
                    'data' => array_column($chartData, 'approved'),
                    'color' => '#10b981',
                ],
                [   'name' => __('resources.acces_request.tab_rejected'),
                    'data' => array_column($chartData, 'rejected'),
                    'color' => '#ef4444',
                ],
            ],
            'xaxis' => [
                'categories' => array_keys($chartData),
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
        ];
    }
}
