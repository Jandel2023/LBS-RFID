<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('profile_img')
                //     ->maxLength(255),
                Forms\Components\FileUpload::make('profile_img')
                    ->label('Profile Image')
                    ->previewable()
                    // ->hiddenOn('view')
                    ->openable()
                    ->columnSpanFull()
                    ->imagePreviewHeight(200)
                    ->imageEditor()
                    ->downloadable()
                    ->image(),
                Forms\Components\ViewField::make('view')
                    ->view('filament.resources.view.js'),
                Forms\Components\Fieldset::make('Personal Details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('rfid')
                            ->required()
                            ->unique(table: 'profiles', column: 'rfid', ignoreRecord: true)
                            ->readOnly()
                            ->suffixAction(
                                \Filament\Forms\Components\Actions\Action::make('Scan')
                                    ->color('gray')
                                    ->icon(fn (Forms\Get $get) => $get('is_listening') ? 'heroicon-m-arrow-path' : 'heroicon-m-identification')
                                    ->extraAttributes(fn (Forms\Get $get) => $get('is_listening') ? ['id' => 'uid-scan-btn', 'class' => 'animate-spin'] : ['id' => 'uid-scan-btn'], true))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('middle_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_img')
                    ->label('Avatar')
                    ->alignCenter()
                    ->circular(),
                Tables\Columns\TextColumn::make('rfid')
                    ->label('RFID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('middle_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('last_name')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\DeleteAction::make()
                    ->before(fn ($record) => $record->borrowers()->update([
                        'status' => false,
                    ])),
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
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'view' => Pages\ViewProfile::route('/{record}'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
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
