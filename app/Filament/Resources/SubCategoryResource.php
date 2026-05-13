<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubCategoryResource\Pages;
use App\Models\SubCategory;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubCategoryResource extends Resource
{
    protected static ?string $model = SubCategory::class;
    protected static ?string $navigationLabel = 'Sous-catégories';
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Catalogue';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations générales')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Catégorie parente')
                            ->relationship('category', 'name')
                            ->required()
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Identifiant unique utilisé par le frontend — ne pas modifier.')
                            ->disabled()
                            ->dehydrated(),
                    ])->columns(2),

                Forms\Components\Section::make('Nom de la sous-catégorie')
                    ->description('Traduisez le nom dans les deux langues')
                    ->schema([
                        Forms\Components\TextInput::make('name.fr')
                            ->label('Nom (Français)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('name.en')
                            ->label('Nom (Anglais)')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->description('⚠️  Sous-catégories verrouillées — liées au frontend. Vous pouvez uniquement modifier les traductions. Aucune création ni suppression n\'est possible.')
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name.fr')
                    ->label('Nom (FR)')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('name.en')
                    ->label('Nom (EN)')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->badge()
                    ->color('primary'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('category_id', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubCategories::route('/'),
            'edit'  => Pages\EditSubCategory::route('/{record}/edit'),
        ];
    }
}
