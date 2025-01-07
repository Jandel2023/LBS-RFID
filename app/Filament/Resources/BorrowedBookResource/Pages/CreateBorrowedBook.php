<?php

namespace App\Filament\Resources\BorrowedBookResource\Pages;

use App\Filament\Resources\BorrowedBookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBorrowedBook extends CreateRecord
{
    protected static string $resource = BorrowedBookResource::class;
}
