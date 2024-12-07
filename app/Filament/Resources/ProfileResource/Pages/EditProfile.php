<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->before(fn ($record) => $record->borrowers()->update([
                    'status' => false,
                ])),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make()
                ->before(fn ($record) => $record->borrowers()->update([
                    'status' => true,
                ])),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update(Arr::except($data, ['view']));

        return $record;
    }
}
