<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommandeResource\Pages;
use App\Models\Commande;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class CommandeResource extends Resource
{
    protected static ?string $model = Commande::class;

    protected static ?string $navigationIcon  = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Commandes';
    protected static ?string $navigationGroup = 'Gestion commerciale';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $modelLabel      = 'Commande';
    protected static ?string $pluralModelLabel = 'Commandes';

    // Badge de comptage dans le menu
    public static function getNavigationBadge(): ?string
    {
        return (string) Commande::where('status', 'en_attente')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    // ─── Formulaire (view-only, pas de création manuelle) ─────────────────────
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations client')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nom')
                        ->disabled(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->disabled(),
                    Forms\Components\TextInput::make('phone')
                        ->label('Téléphone')
                        ->disabled(),
                    Forms\Components\Select::make('status')
                        ->label('Statut')
                        ->options(Commande::STATUSES)
                        ->required(),
                    Forms\Components\TextInput::make('total')
                        ->label('Total')
                        ->disabled()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('message')
                        ->label('Message')
                        ->disabled()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    // ─── Table liste ──────────────────────────────────────────────────────────
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Client')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copié'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Articles')
                    ->getStateUsing(fn ($record) => $record->items->count() . ' article(s)')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut')
                    ->formatStateUsing(fn ($state) => Commande::STATUSES[$state] ?? $state)
                    ->colors([
                        'warning' => 'en_attente',
                        'primary' => 'confirmee',
                        'purple'  => 'en_cours',
                        'success' => 'terminee',
                        'danger'  => 'annulee',
                    ])
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options(Commande::STATUSES),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Action::make('confirmer')
                    ->label('Confirmer')
                    ->icon('heroicon-o-check-circle')
                    ->color('primary')
                    ->visible(fn ($record) => $record->status === 'en_attente')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => 'confirmee']);
                        Notification::make()
                            ->title('Commande confirmée')
                            ->success()
                            ->send();
                    }),

                Action::make('en_cours')
                    ->label('En cours')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->visible(fn ($record) => $record->status === 'confirmee')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => 'en_cours']);
                        Notification::make()
                            ->title('Statut mis à jour : En cours')
                            ->success()
                            ->send();
                    }),

                Action::make('terminer')
                    ->label('Terminer')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'en_cours')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update(['status' => 'terminee']);
                        Notification::make()
                            ->title('Commande terminée')
                            ->success()
                            ->send();
                    }),

                Action::make('annuler')
                    ->label('Annuler')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => !in_array($record->status, ['terminee', 'annulee']))
                    ->requiresConfirmation()
                    ->modalHeading('Annuler la commande ?')
                    ->modalDescription('Cette action ne peut pas être annulée.')
                    ->action(function ($record) {
                        $record->update(['status' => 'annulee']);
                        Notification::make()
                            ->title('Commande annulée')
                            ->danger()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => in_array($record->status, ['terminee', 'annulee'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // ─── Pages ────────────────────────────────────────────────────────────────
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommandes::route('/'),
            'view'  => Pages\ViewCommande::route('/{record}'),
            'edit'  => Pages\EditCommande::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
