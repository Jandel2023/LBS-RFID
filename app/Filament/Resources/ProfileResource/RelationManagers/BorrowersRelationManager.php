<?php

namespace App\Filament\Resources\ProfileResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BorrowersRelationManager extends RelationManager
{
    protected static string $relationship = 'borrowers';

    // protected static ?string $label = 'Booked Borrowed';
    protected static ?string $title = 'Borrowed Books';

    protected static ?string $modelLabel = 'Borrowed Books';

    // protected static ?string $pluralLabel = 'Borrowed Books';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('book_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('book_id')
            ->columns([
                Tables\Columns\TextColumn::make('borrowed_books.book.isbn')
                    ->label('ISBN')
                    ->searchable(['isbn'])
                    ->bulleted()
                    ->listWithLineBreaks()
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Medium),
                Tables\Columns\TextColumn::make('borrowed_books.book.title')
                    ->label('Title')
                    ->searchable(['title'])
                    // ->bulleted()
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Medium)
                    ->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('borrowed_books.book.author.full_name')
                    ->label('Author')
                    // ->searchable([''])
                    // ->bulleted()
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Medium)
                    ->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('borrowed_books.book.category.name')
                    ->label('Category')
                    ->searchable(['name'])
                    // ->bulleted()
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Medium)

                    ->listWithLineBreaks(),
            ])
            // ->inverseRelationship('booked_books')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
