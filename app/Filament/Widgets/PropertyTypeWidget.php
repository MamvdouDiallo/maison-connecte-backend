<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\Devis;
use App\Models\QuoteRequest;

class PropertyTypeWidget extends BarChartWidget
{
    protected static ?string $heading     = 'Répartition des demandes';
    protected static ?string $description = 'Types de biens et budgets des devis reçus';
    protected static ?int    $sort        = 5;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $types = ['villa', 'appartement', 'bureau', 'commerce', 'autre'];

        $labels = array_map('ucfirst', $types);

        $counts = collect($types)->map(
            fn($type) => Devis::where('property_type', $type)->count()
        )->values()->toArray();

        return [
            'labels'   => $labels,
            'datasets' => [
                [
                    'label'           => 'Nombre de devis',
                    'data'            => $counts,
                    'backgroundColor' => [
                        '#0097A7',
                        '#42B7C4',
                        '#1A1A1A',
                        '#f59e0b',
                        '#94a3b8',
                    ],
                    'borderRadius'    => 8,
                    'borderWidth'     => 0,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins'   => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks'       => ['stepSize' => 1],
                    'grid'        => ['color' => 'rgba(0,0,0,0.04)'],
                ],
                'y' => [
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }
}
