<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Category;
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
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Catalogue';
    protected static ?int $navigationSort = 3;

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->label('Catégorie')
                    ->relationship('category', 'name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('subcategory_id', null)),

                Forms\Components\Select::make('subcategory_id')
                    ->label('Sous-catégorie')
                    ->options(fn (callable $get) => SubCategory::where('category_id', $get('category_id'))->pluck('name', 'id'))
                    ->searchable(),

                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->nullable()->rows(4),
                Forms\Components\TextInput::make('price')->numeric()->nullable(),
                Forms\Components\TextInput::make('link')->url()->nullable(),
                Forms\Components\Textarea::make('highlights')->label('Points forts')->json(),
                Forms\Components\Textarea::make('specs')->label('Spécifications')->json(),

                FileUpload::make('images')
                    ->label('Images')
                    ->multiple()
                    ->image()
                    ->directory('products'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Catégorie')->sortable(),
                Tables\Columns\TextColumn::make('subCategory.name')->label('Sous-catégorie')->sortable(),
                Tables\Columns\TextColumn::make('price')->money('usd', true),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
