<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectTypeResource\Pages;
use App\Models\ProjectType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectTypeResource extends Resource
{
    protected static ?string $model = ProjectType::class;

    protected static ?string $navigationIcon  = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?string $navigationLabel = 'Types de projets';
    protected static ?int    $navigationSort  = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name.fr')
                    ->label('Nom (FR)')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        if (!$get('slug')) {
                            $set('slug', Str::slug($state));
                        }
                    }),

                Forms\Components\TextInput::make('name.en')
                    ->label('Nom (EN)'),
            ]),

            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->unique(ProjectType::class, 'slug', ignoreRecord: true)
                ->required(),

            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Textarea::make('description.fr')
                    ->label('Description (FR)')
                    ->rows(3),

                Forms\Components\Textarea::make('description.en')
                    ->label('Description (EN)')
                    ->rows(3),
            ]),

            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('icon')
                    ->label('Icône (heroicon)')
                    ->placeholder('heroicon-o-home'),

                Forms\Components\ColorPicker::make('color')
                    ->label('Couleur')
                    ->default('#0097A7'),

                Forms\Components\TextInput::make('order')
                    ->label("Ordre d'affichage")
                    ->numeric()
                    ->default(0),
            ]),

            Forms\Components\Toggle::make('is_active')
                ->label('Actif')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name.fr')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug'),

                Tables\Columns\ColorColumn::make('color')
                    ->label('Couleur'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('projects_count')
                    ->label('Projets')
                    ->counts('projects'),

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
            'index'  => Pages\ListProjectTypes::route('/'),
            'create' => Pages\CreateProjectType::route('/create'),
            'edit'   => Pages\EditProjectType::route('/{record}/edit'),
        ];
    }
}
