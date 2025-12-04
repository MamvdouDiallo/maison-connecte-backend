<?php

namespace App\Filament\Resources;

use App\Models\QuoteRequest;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationGroup = 'Demandes';
    protected static ?string $navigationLabel = 'Demandes de devis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations générales')
                    ->schema([
                        Forms\Components\TextInput::make('service_type')->required(),
                        Forms\Components\TextInput::make('residence_type')->required(),
                        Forms\Components\DatePicker::make('estimated_date')->required(),
                    ]),

                Forms\Components\Section::make('Types de projet')
                    ->schema([
                        Forms\Components\Toggle::make('security_electronic'),
                        Forms\Components\Toggle::make('smart_home'),
                        Forms\Components\Toggle::make('solar_installation'),
                        Forms\Components\Toggle::make('premium_finishes'),
                        Forms\Components\Toggle::make('complete_project'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Détails installation')
                    ->schema([
                        Forms\Components\TextInput::make('property_type')->required(),
                        Forms\Components\TextInput::make('address')->required(),
                        Forms\Components\TextInput::make('surface')->required(),
                        Forms\Components\TextInput::make('floors')->required(),
                        Forms\Components\TextInput::make('current_state')->required(),
                        Forms\Components\Textarea::make('project_needs'),
                        Forms\Components\TextInput::make('budget')->required(),
                        Forms\Components\DatePicker::make('intervention_date'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informations client')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('phone')->required(),
                        Forms\Components\TextInput::make('email')->email()->required(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Fichiers fournis')
                    ->schema([
                        Forms\Components\FileUpload::make('files')
                            ->multiple()
                            ->directory('quote-requests')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Client')->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('service_type')->label('Service'),
                Tables\Columns\TextColumn::make('residence_type')->label('Résidence'),
                Tables\Columns\TextColumn::make('estimated_date')->date(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => QuoteRequestResource\Pages\ListQuoteRequests::route('/'),
            'edit'  => QuoteRequestResource\Pages\EditQuoteRequest::route('/{record}/edit'),
        ];
    }
}
