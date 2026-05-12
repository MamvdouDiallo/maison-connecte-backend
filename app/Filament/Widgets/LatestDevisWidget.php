<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Devis;

class LatestDevisWidget extends BaseWidget
{
    protected static ?string $heading = 'Dernières demandes de devis';
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(Devis::latest()->limit(6))
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Client')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('property_type')
                    ->label('Type')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('budget')
                    ->label('Budget')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('smart_home')
                    ->label('Domotique')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->paginated(false);
    }
}
