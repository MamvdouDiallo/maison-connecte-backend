<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinitionResource\Pages;
use App\Models\Finition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FinitionResource extends Resource
{
    protected static ?string $model = Finition::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationGroup = 'Catalogue';
    protected static ?string $navigationLabel = 'Finitions';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Titre')
                    ->schema([
                        Forms\Components\TextInput::make('titre.fr')
                            ->label('Titre (FR)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('titre.en')
                            ->label('Titre (EN)')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\Textarea::make('description.fr')
                            ->label('Description (FR)')
                            ->required()
                            ->rows(4),
                        Forms\Components\Textarea::make('description.en')
                            ->label('Description (EN)')
                            ->rows(4),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Catégorie & Ordre')
                    ->schema([
                        Forms\Components\Select::make('categorie')
                            ->label('Catégorie')
                            ->options([
                                'peinture'   => 'Peinture',
                                'carrelage'  => 'Carrelage',
                                'menuiserie' => 'Menuiserie',
                                'design'     => 'Design',
                                'plafonds'   => 'Plafonds',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('ordre')
                            ->label('Ordre d\'affichage')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Photo principale')
                            ->image()
                            ->directory('finitions')
                            ->visibility('public')
                            ->required()
                            ->maxSize(4096)
                            ->imageEditor()
                            ->previewable(),

                        Forms\Components\FileUpload::make('galerie')
                            ->label('Galerie (images supplémentaires)')
                            ->image()
                            ->multiple()
                            ->directory('finitions')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->previewable()
                            ->reorderable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->square()
                    ->size(60),

                Tables\Columns\TextColumn::make('titre.fr')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\BadgeColumn::make('categorie')
                    ->label('Catégorie')
                    ->colors([
                        'warning' => 'peinture',
                        'success' => 'carrelage',
                        'primary' => 'menuiserie',
                        'danger'  => 'design',
                        'gray'    => 'plafonds',
                    ]),

                Tables\Columns\TextColumn::make('ordre')
                    ->label('Ordre')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('ordre', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('categorie')
                    ->label('Catégorie')
                    ->options([
                        'peinture'   => 'Peinture',
                        'carrelage'  => 'Carrelage',
                        'menuiserie' => 'Menuiserie',
                        'design'     => 'Design',
                        'plafonds'   => 'Plafonds',
                    ]),
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
            'index'  => Pages\ListFinitions::route('/'),
            'create' => Pages\CreateFinition::route('/create'),
            'edit'   => Pages\EditFinition::route('/{record}/edit'),
        ];
    }
}
