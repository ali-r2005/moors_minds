<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactRequestResource\Pages;
use App\Filament\Resources\ContactRequestResource\RelationManagers;
use App\Models\ContactRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactRequestResource extends Resource
{
    protected static ?string $model = ContactRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                ]);
    }
    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('full_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->copyable()->searchable(),
            Tables\Columns\TextColumn::make('service.title')->label('Service'),
            Tables\Columns\SelectColumn::make('status')
            ->label('Status')
            ->options([
                'pending' => 'Pending',
                'handled' => 'Handled',
                'archived' => 'Archived',
            ])
            ->sortable(),
            Tables\Columns\TextColumn::make('source')->label('Source')->sortable(),
            Tables\Columns\TextColumn::make('created_at')->since()->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'handled' => 'Handled',
                    'archived' => 'Archived',
                ]),
        ])
        ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListContactRequests::route('/'),
        ];
    }
}
