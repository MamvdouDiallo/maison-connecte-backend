<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\RevenueWidget;
use App\Filament\Widgets\StatsChartWidget;
use App\Filament\Widgets\ServiceBreakdownWidget;
use App\Filament\Widgets\PropertyTypeWidget;
use App\Filament\Widgets\LatestDevisWidget;
use App\Filament\Widgets\LatestContactsWidget;
use App\Filament\Widgets\LatestComandesWidget;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title          = 'Tableau de bord';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $navigationIcon  = 'heroicon-o-home';
    protected static ?int    $navigationSort  = 0;

    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,   // sort=1 — 8 KPIs activité + catalogue  (full)
            RevenueWidget::class,          // sort=2 — CA mois / total / panier moyen (full)
            StatsChartWidget::class,       // sort=3 — Courbes activité 6 mois       (full)
            ServiceBreakdownWidget::class, // sort=4 — Bar chart services demandés   (½)
            PropertyTypeWidget::class,     // sort=5 — Bar chart types de bien       (½)
            LatestDevisWidget::class,      // sort=6 — Derniers devis                (½)
            LatestContactsWidget::class,   // sort=7 — Derniers messages             (½)
            LatestComandesWidget::class,   // sort=8 — Dernières commandes           (full)
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 2,
        ];
    }
}
