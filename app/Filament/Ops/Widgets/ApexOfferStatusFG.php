<?php

namespace App\Filament\Ops\Widgets;

use App\Traits\OfferStatusTrait;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ApexOfferStatusFG extends ApexChartWidget
{

    use OfferStatusTrait;

    public static ?int $sort = 3;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'apexOfferStatus';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Cantidad de ofertas';

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
