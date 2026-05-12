<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\SubCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationLabel = 'Produits';
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Catalogue';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations générales')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Catégorie')
                            ->relationship('category', 'name')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($set) => $set('subcategory_id', null)),

                        Forms\Components\Select::make('subcategory_id')
                            ->label('Sous-catégorie')
                            ->options(fn (Forms\Get $get) => SubCategory::where('category_id', $get('category_id'))->pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),

                        Forms\Components\TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->afterStateHydrated(function ($component, $state) {
                                if (is_array($state)) {
                                    $component->state($state['fr'] ?? $state['en'] ?? '');
                                }
                            })
                            ->dehydrateStateUsing(fn ($state) => ['fr' => $state, 'en' => $state]),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->nullable()
                            ->rows(4)
                            ->afterStateHydrated(function ($component, $state) {
                                if (is_array($state)) {
                                    $component->state($state['fr'] ?? $state['en'] ?? '');
                                }
                            })
                            ->dehydrateStateUsing(fn ($state) => $state ? ['fr' => $state, 'en' => $state] : null),

                        Forms\Components\TextInput::make('price')
                            ->label('Prix (F CFA)')
                            ->numeric()
                            ->nullable(),

                        Forms\Components\TextInput::make('link')
                            ->label('Lien')
                            ->url()
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Image')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Image principale')
                            ->image()
                            ->directory('products')
                            ->nullable(),
                    ]),

                Forms\Components\Section::make('Détails techniques')
                    ->schema([
                        Forms\Components\TagsInput::make('highlights')
                            ->label('Points forts')
                            ->placeholder('Ajouter un point fort...')
                            ->nullable(),

                        Forms\Components\TagsInput::make('specs')
                            ->label('Spécifications')
                            ->placeholder('Ajouter une spec...')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->formatStateUsing(fn ($state) => is_array($state) ? ($state['fr'] ?? '') : $state)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subCategory.name')
                    ->label('Sous-catégorie')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Prix')
                    ->suffix(' F CFA')
                    ->sortable(),
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
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
