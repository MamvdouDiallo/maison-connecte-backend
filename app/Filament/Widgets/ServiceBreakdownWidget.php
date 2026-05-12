<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\Devis;
use Carbon\Carbon;

class ServiceBreakdownWidget extends BarChartWidget
{
    protected static ?string $heading     = 'Services les plus demandés';
    protected static ?string $description = 'Répartition des devis par service (6 derniers mois)';
    protected static ?int    $sort        = 4;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $labels = [];
        $months = [];

        for ($i = 5; $i >= 0; $i--) {
            $month    = Carbon::now()->subMonths($i);
            $labels[] = ucfirst($month->translatedFormat('M'));
            $months[] = $month;
        }

        $make = fn(string $field) => collect($months)->map(
            fn(Carbon $m) => Devis::where($field, true)
                ->whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)
                ->count()
        )->values()->toArray();

        return [
            'labels'   => $labels,
            'datasets' => [
                [
                    'label'           => 'Domotique',
                    'data'            => $make('smart_home'),
                    'backgroundColor' => '#0097A7',
                    'borderRadius'    => 6,
                ],
                [
                    'label'           => 'Solaire',
                    'data'            => $make('solar_installation'),
                    'backgroundColor' => '#f59e0b',
                    'borderRadius'    => 6,
                ],
                [
                    'label'           => 'Sécurité',
                    'data'            => $make('security_electronic'),
                    'backgroundColor' => '#ef4444',
                    'borderRadius'    => 6,
                ],
                [
                    'label'           => 'Finitions',
                    'data'            => $make('premium_finishes'),
                    'backgroundColor' => '#42B7C4',
                    'borderRadius'    => 6,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['position' => 'bottom'],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks'       => ['stepSize' => 1],
                    'grid'        => ['color' => 'rgba(0,0,0,0.04)'],
                ],
                'x' => [
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }
}
