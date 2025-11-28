<?php
namespace App\Filament\Pages;
use Filament\Pages\Page;
use App\Filament\Widgets\StatsOverviewWidget;

class Dashboard extends Page
{
    protected static ?string $title = 'Tableau de bord';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?int $navigationSort = 1;

    protected static function getWidgets(): array
    {
        return [
            StatsChartWidget::class,
            StatsOverviewWidget::class,

        ];
    }
}
