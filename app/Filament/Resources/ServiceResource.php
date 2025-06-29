<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextInput::make('slug')->required()->unique(),
                Forms\Components\TextInput::make('subtitle'),
                Forms\Components\Textarea::make('description')->required(),
                Forms\Components\TagsInput::make('use_cases')->label('Use Cases'),
                Forms\Components\TagsInput::make('features')->label('Features'),
                Forms\Components\FileUpload::make('image_url')
                ->image()
                ->directory('services/images') 
                ->preserveFilenames(),
                Forms\Components\TextInput::make('cta_label'),
                Forms\Components\TextInput::make('cta_link'),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([   
            Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->limit(30),

            Tables\Columns\TextColumn::make('subtitle')
                ->limit(40)
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('slug')
                ->copyable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('category.name')
                ->label('Category')
                ->sortable()
                ->badge(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created')
                ->dateTime('Y-m-d')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('category')
                ->relationship('category', 'name')
                ->label('Category'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
