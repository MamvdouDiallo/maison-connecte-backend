<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationLabel = 'Réglages du site';
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Configuration du site';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Clé')
                            ->disabled()
                            ->dehydrated()
                            ->helperText('Identifiant technique utilisé par le site — ne pas modifier.'),

                        Forms\Components\TextInput::make('label')
                            ->label('Nom affiché')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('value')
                            ->label('Valeur')
                            ->visible(fn (Forms\Get $get) => $get('type') !== 'translatable_text')
                            ->url(fn (Forms\Get $get) => $get('type') === 'url')
                            ->placeholder(fn (Forms\Get $get) => $get('type') === 'url'
                                ? 'Ex: https://www.youtube.com/watch?v=XXXXXXXXXXX'
                                : null)
                            ->helperText('Laissez vide pour garder le texte par défaut du site.'),

                        Forms\Components\Grid::make(2)
                            ->visible(fn (Forms\Get $get) => $get('type') === 'translatable_text')
                            ->schema([
                                Forms\Components\Textarea::make('value_json.fr')
                                    ->label('Valeur (Français)')
                                    ->rows(3),

                                Forms\Components\Textarea::make('value_json.en')
                                    ->label('Valeur (Anglais)')
                                    ->rows(3),
                            ]),

                        Forms\Components\Placeholder::make('translatable_help')
                            ->visible(fn (Forms\Get $get) => $get('type') === 'translatable_text')
                            ->label('')
                            ->content('Laissez un champ vide pour garder le texte par défaut du site dans cette langue.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description('⚠️ Réglages globaux du site — aucune création ni suppression n\'est possible ici.')
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Réglage')
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('value')
                    ->label('Valeur actuelle')
                    ->state(fn (Setting $record) => $record->type === 'translatable_text'
                        ? ($record->value_json['fr'] ?? $record->value_json['en'] ?? null)
                        : $record->value)
                    ->limit(60)
                    ->placeholder('— vide (texte par défaut utilisé) —')
                    ->wrap(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit'  => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
