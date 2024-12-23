<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource\Pages;

use App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditMeeting extends EditRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['status'])) {
            $data['status'] = 'saved'; // Establece el valor predeterminado del campo 'status' si está vacío
        }

        //Manejo de archivo
        if (!empty($data['attachment'])) {
            $existingFile = $this->record->file; // Obtén el archivo relacionado actual


            if ($existingFile) {
                Storage::delete($existingFile->storage_path);
            }

            $this->record->file()->create(
                [
                    'storage_path' => $data['attachment'],   // Ruta completa en el disco
                    'name'         => basename($data['attachment']), // Nombre del archivo
                    'type'         => 'attachment_file'
                ]
            );
        }

        return $data;
    }
}
