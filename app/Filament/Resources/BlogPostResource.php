<?php

namespace App\Filament\Resources;
use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use App\Models\Category;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Blog';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('category_id')
                ->label('Category')
                ->options(Category::pluck('name', 'id'))
                ->required(),

            Forms\Components\TextInput::make('title')->required(),

            Forms\Components\Textarea::make('excerpt')->rows(4),

            Forms\Components\FileUpload::make('image')
                ->directory('blog')
                ->image()
                ->columnSpan('full'),

            Forms\Components\TextInput::make('author'),
            Forms\Components\TextInput::make('read_time')->label('Read Time'),

            Forms\Components\DatePicker::make('published_at')->required(),
        ])->columns(2);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->square()->size(60),

            Tables\Columns\TextColumn::make('title')->searchable(),

            Tables\Columns\TextColumn::make('category.name')->label('Category'),

            Tables\Columns\TextColumn::make('published_at')->date(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
