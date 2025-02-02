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
use App\Models\Category;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\FileUpload::make('photo')
                ->label('Photo')
                ->image()
                ->required(),
            Forms\Components\TextInput::make('rate_per_hour')
                ->label('Rate per Hour')
                ->required(),
            Forms\Components\TextInput::make('location')
                ->label('Location')
                ->required(),
            Forms\Components\TextInput::make('contact')
                ->label('Contact')
                ->required(),
            Forms\Components\Select::make('category_id')
                ->label('Service Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\ImageColumn::make('photo')  // Display the photo column as an image
                ->label('Service Photo')
                ->width(100)  // You can adjust the width as needed
                ->height(100)  // Adjust height as needed
                ->size(50)  // Optional: Specify size
                ->getStateUsing(fn($record) => asset('storage/' . $record->photo)),  // Get the correct path for the image
            Tables\Columns\TextColumn::make('rate_per_hour')
                ->label('Rate per Hour')
                ->money('USD'),
            Tables\Columns\TextColumn::make('location')
                ->label('Location'),
            Tables\Columns\TextColumn::make('contact')
                ->label('Contact'),
            Tables\Columns\TextColumn::make('category.name')
                ->label('Category'),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
