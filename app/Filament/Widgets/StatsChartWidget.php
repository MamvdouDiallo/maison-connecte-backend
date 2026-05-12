<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Commande;
use App\Models\Devis;
use App\Models\Contact;
use App\Models\QuoteRequest;
use Carbon\Carbon;

class StatsChartWidget extends LineChartWidget
{
    protected static ?string $heading = 'Activité des 6 derniers mois';
    protected static ?string $description = 'Évolution des commandes, devis et contacts';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $labels = [];
        $months = [];

        for ($i = 5; $i >= 0; $i--) {
            $month    = Carbon::now()->subMonths($i);
            $labels[] = ucfirst($month->translatedFormat('M Y'));
            $months[] = $month;
        }

        return [
            'labels'   => $labels,
            'datasets' => [
                [
                    'label'           => 'Commandes',
                    'data'            => $this->countPerMonth(Commande::class, $months),
                    'borderColor'     => '#10b981',
                    'backgroundColor' => '#10b98115',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'pointBackgroundColor' => '#10b981',
                    'pointRadius'     => 4,
                ],
                [
                    'label'           => 'Demandes de devis',
                    'data'            => $this->countPerMonth(Devis::class, $months),
                    'borderColor'     => '#f59e0b',
                    'backgroundColor' => '#f59e0b15',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'pointBackgroundColor' => '#f59e0b',
                    'pointRadius'     => 4,
                ],
                [
                    'label'           => 'Messages contact',
                    'data'            => $this->countPerMonth(Contact::class, $months),
                    'borderColor'     => '#3b82f6',
                    'backgroundColor' => '#3b82f615',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'pointBackgroundColor' => '#3b82f6',
                    'pointRadius'     => 4,
                ],
                [
                    'label'           => 'Devis formulaire',
                    'data'            => $this->countPerMonth(QuoteRequest::class, $months),
                    'borderColor'     => '#8b5cf6',
                    'backgroundColor' => '#8b5cf615',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'pointBackgroundColor' => '#8b5cf6',
                    'pointRadius'     => 4,
                ],
            ],
        ];
    }

    private function countPerMonth(string $model, array $months): array
    {
        return collect($months)
            ->map(fn(Carbon $month) => $model::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count()
            )
            ->values()
            ->toArray();
    }
}
