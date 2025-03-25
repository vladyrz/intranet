<?php

namespace App\Filament\Personal\Widgets;

use App\Filament\Personal\Traits\PersonalOfferTrait;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ApexPersonalOfferStatus extends ApexChartWidget
{

    use PersonalOfferTrait;

    public static ?int $sort = 3;
    protected static string $chartId = 'apexPersonalOfferStatus';
    protected static ?string $heading = 'Cantidad de ofertas';
    protected int|string|array $columnSpan = 'full';

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
                'fontFamily' => 'inherit',
            ],
            'series' => [
                [
                    'name' => __('resources.offer.tab_offer_status.0'),
                    'data' => array_column($chartData, 'pending'),
                    'color' => '#facc15',
                ],
                [
                    'name' => __('resources.offer.tab_offer_status.1'),
                    'data' => array_column($chartData, 'sent'),
                    'color' => '#3b82f6',
                ],
                [
                    'name' => __('resources.offer.tab_offer_status.2'),
                    'data' => array_column($chartData, 'approved'),
                    'color' => '#10b981',
                ],
                [
                    'name' => __('resources.offer.tab_offer_status.3'),
                    'data' => array_column($chartData, 'rejected'),
                    'color' => '#ef4444',
                ],
                [
                    'name' => __('resources.offer.tab_offer_status.4'),
                    'data' => array_column($chartData, 'signed'),
                    'color' => '#8b5cf6',
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
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }
}
