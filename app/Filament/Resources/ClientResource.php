<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon  = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?string $navigationLabel = 'Partenaires';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Informations principales')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nom du partenaire')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, callable $set, $get) =>
                            !$get('slug') ? $set('slug', Str::slug($state)) : null
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->unique(Client::class, 'slug', ignoreRecord: true)
                        ->required(),
                ]),

                Forms\Components\FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->directory('clients')
                    ->nullable(),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->nullable(),
            ]),

            Forms\Components\Section::make('Coordonnées')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('contact_person')
                        ->label('Personne de contact'),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email(),
                ]),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('phone')
                        ->label('Téléphone'),

                    Forms\Components\TextInput::make('website')
                        ->label('Site web')
                        ->url(),
                ]),

                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('address')
                        ->label('Adresse'),

                    Forms\Components\TextInput::make('city')
                        ->label('Ville'),

                    Forms\Components\TextInput::make('country')
                        ->label('Pays')
                        ->default('Sénégal'),
                ]),
            ]),

            Forms\Components\Section::make('Partenariat')->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('industry')
                        ->label('Secteur d\'activité'),

                    Forms\Components\DatePicker::make('partnership_start')
                        ->label('Début du partenariat'),

                    Forms\Components\TextInput::make('order')
                        ->label("Ordre d'affichage")
                        ->numeric()
                        ->default(0),
                ]),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Actif')
                        ->default(true),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('Mis en avant')
                        ->default(false),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->height(40),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('industry')
                    ->label('Secteur'),

                Tables\Columns\TextColumn::make('city')
                    ->label('Ville'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Mis en avant')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit'   => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
