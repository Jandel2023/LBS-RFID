<?php

namespace App\Filament\Resources\BorrowedBookResource\Pages;

use App\Filament\Resources\BorrowedBookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBorrowedBook extends EditRecord
{
    protected static string $resource = BorrowedBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
