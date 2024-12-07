<?php

namespace App\Filament\Resources\BorrowerResource\Pages;

use App\Filament\Resources\BorrowerResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditBorrower extends EditRecord
{
    protected static string $resource = BorrowerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('profile_id')
                    ->required()
                    ->relationship(name: 'profile')
                    ->preload()
                    ->searchable(['last_name', 'first_name', 'middle_name'])
                    ->disabled(fn ($record) => $record->status == 0 || false)
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record?->full_name),
                Forms\Components\DateTimePicker::make('created_at')
                    ->label('Borrowed At')
                    ->default(now())
                    ->native(false)
                    ->readonly(),
                // ->numeric(),
            ]);
    }
}
