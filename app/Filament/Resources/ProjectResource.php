<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use App\Models\ProjectService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon  = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?string $navigationLabel = 'Projets réalisés';
    protected static ?int    $navigationSort  = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Informations principales')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('title.fr')
                        ->label('Titre (FR)')
                        ->required(),

                    Forms\Components\TextInput::make('title.en')
                        ->label('Titre (EN)'),
                ]),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\RichEditor::make('description.fr')
                        ->label('Description (FR)')
                        ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),

                    Forms\Components\RichEditor::make('description.en')
                        ->label('Description (EN)')
                        ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),
                ]),
            ]),

            Forms\Components\Section::make('Détails')->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Select::make('project_type_id')
                        ->label('Type de projet')
                        ->relationship('projectType', 'id')
                        ->getOptionLabelFromRecordUsing(fn($record) => $record->name['fr'] ?? '')
                        ->preload()
                        ->required(),

                    Forms\Components\TextInput::make('location')
                        ->label('Localisation'),

                    Forms\Components\TextInput::make('year')
                        ->label('Année')
                        ->maxLength(4)
                        ->placeholder('2024'),
                ]),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('client')
                        ->label('Client'),

                    Forms\Components\TextInput::make('duration')
                        ->label('Durée')
                        ->placeholder('3 mois'),
                ]),
            ]),

            Forms\Components\Section::make('Médias')->schema([
                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Image principale')
                    ->image()
                    ->directory('projects/thumbnails'),

                Forms\Components\Repeater::make('images')
                    ->label('Galerie')
                    ->relationship()
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Image')
                            ->image()
                            ->directory('projects/gallery')
                            ->required(),

                        Forms\Components\TextInput::make('order')
                            ->label('Ordre')
                            ->numeric()
                            ->default(0),
                    ])
                    ->addActionLabel('Ajouter une image')
                    ->collapsible(),
            ]),

            Forms\Components\Section::make('Tags & Services')->schema([
                Forms\Components\Repeater::make('tags')
                    ->label('Tags')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('tag')
                            ->label('Tag')
                            ->required(),
                    ])
                    ->addActionLabel('Ajouter un tag')
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Repeater::make('services')
                    ->label('Services réalisés')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('service')
                            ->label('Service')
                            ->options([
                                'security'   => 'Sécurité',
                                'automation' => 'Domotique',
                                'solar'      => 'Solaire',
                                'finishing'  => 'Finitions',
                            ])
                            ->required(),
                    ])
                    ->addActionLabel('Ajouter un service')
                    ->columns(2)
                    ->collapsible(),
            ]),

            Forms\Components\Section::make('Publication')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Visible sur le site')
                        ->default(true),

                    Forms\Components\TextInput::make('order')
                        ->label("Ordre d'affichage")
                        ->numeric()
                        ->default(0),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Photo')
                    ->height(50),

                Tables\Columns\TextColumn::make('title.fr')
                    ->label('Titre')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('projectType.name')
                    ->label('Type')
                    ->formatStateUsing(fn($state) => is_array($state) ? ($state['fr'] ?? '') : $state),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lieu'),

                Tables\Columns\TextColumn::make('year')
                    ->label('Année')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('project_type_id')
                    ->label('Type de projet')
                    ->relationship('projectType', 'id')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name['fr'] ?? ''),
            ])
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
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
