<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BorrowerResource\Pages;
use App\Models\Borrower;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowerResource extends Resource
{
    protected static ?string $model = Borrower::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('profile_id')
                    ->required()
                    ->relationship(name: 'profile')
                    ->preload()
                    ->live()
                    ->searchable(['last_name', 'first_name', 'middle_name'])
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record?->full_name),
                Forms\Components\DateTimePicker::make('created_at')
                    ->label('Borrowed At')
                    ->default(now())
                    ->native(false)
                    ->readonly(),
                // ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $borrower = fn (Borrower $record) => $record->profile()->first() == null;

        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile.profile_img')
                    ->label('Avatar')
                    ->alignCenter()
                    ->circular(),
                Tables\Columns\TextColumn::make('profile.rfid')
                    ->label('RFID')
                    ->default('Deleted')
                    ->badge($borrower)
                    ->sortable(),
                Tables\Columns\TextColumn::make('profile.full_name')
                    ->default('Deleted')
                    ->badge($borrower)
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Borrowed At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListBorrowers::route('/'),
            'create' => Pages\CreateBorrower::route('/create'),
            'view' => Pages\ViewBorrower::route('/{record}'),
            'edit' => Pages\EditBorrower::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
