<?php

namespace App\Filament\Resources\CommandeResource\Pages;

use App\Filament\Resources\CommandeResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;

class ViewCommande extends ViewRecord
{
    protected static string $resource = CommandeResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Components\Section::make('Informations client')
                ->columns(2)
                ->schema([
                    Components\TextEntry::make('name')->label('Nom'),
                    Components\TextEntry::make('email')->label('Email')->copyable(),
                    Components\TextEntry::make('phone')->label('Téléphone'),
                    Components\TextEntry::make('total')->label('Total')->badge()->color('success'),
                    Components\TextEntry::make('status')
                        ->label('Statut')
                        ->formatStateUsing(fn ($state) => \App\Models\Commande::STATUSES[$state] ?? $state)
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'en_attente' => 'warning',
                            'confirmee'  => 'primary',
                            'en_cours'   => 'warning',
                            'terminee'   => 'success',
                            'annulee'    => 'danger',
                            default      => 'gray',
                        }),
                    Components\TextEntry::make('created_at')
                        ->label('Date de commande')
                        ->dateTime('d/m/Y à H:i'),
                    Components\TextEntry::make('message')
                        ->label('Message client')
                        ->columnSpanFull()
                        ->placeholder('Aucun message'),
                ]),

            Components\Section::make('Articles commandés')
                ->schema([
                    Components\RepeatableEntry::make('items')
                        ->label('')
                        ->schema([
                            Components\TextEntry::make('title')->label('Produit'),
                            Components\TextEntry::make('price')->label('Prix unitaire'),
                            Components\TextEntry::make('quantity')->label('Quantité'),
                            Components\TextEntry::make('line_total')->label('Sous-total')->badge()->color('info'),
                        ])
                        ->columns(4),
                ]),
        ]);
    }
}
