<?php

namespace App\Filament\Clusters\Documents\Resources\Documents\ManualResource\Pages;

use App\Filament\Clusters\Documents\Resources\Documents\ManualResource;
use App\Models\Documents\Manual;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use Str;

class EditManual extends EditRecord
{
    protected static string $resource = ManualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            // Actions\Action::make('approve')
            //     ->label('Enviar a aprobación')
            //     ->action(function (Manual $record) {
            //         $record->createApproval();
            //         Notification::make()
            //             ->title('Manual enviado a aprobación')
            //             ->success()
            //             ->send();
            //     })
            //     ->icon('heroicon-o-check-circle')
            //     ->requiresConfirmation()
            //     ->color('success')
            //     ->visible(fn (Manual $record): bool => ! $record->approval()->exists()),
            // Actions\Action::make('deleteApproval')
            //     ->label('Eliminar aprobación')
            //     ->action(function (Manual $record) {
            //         if ($record->approval) {
            //             $record->approval->delete();
            //             Notification::make()
            //                 ->title('Aprobación eliminada')
            //                 ->success()
            //                 ->send();
            //         } else {
            //             Notification::make()
            //                 ->title('No hay aprobacion para eliminar')
            //                 ->danger()
            //                 ->send();
            //         }
            //     })
            //     ->icon('heroicon-o-x-circle')
            //     ->requiresConfirmation()
            //     ->color('danger')
            //     ->visible(fn (Manual $record): bool => $record->approval()->exists() && $record->approval->status == true),
            Actions\Action::make('generatePdf')
                ->label('Generar PDF')
                ->action(function (Manual $record) {
                    $pdfContent = Pdf::loadView('documents.manuals.show', [
                        'record'        => $record,
                        'establishment' => auth()->user()->establishment,
                    ])->output();

                    $name = Str::snake($record->id . ' ' . $record->title)."_v{$record->version}.pdf";
                    $fileName = "documents/manuals/{$name}";
                    Storage::put($fileName, $pdfContent);

                    $record->file = $fileName;
                    $record->save();

                    Notification::make()
                        ->title('PDF generado y almacenado')
                        ->success()
                        ->send();
                })
                ->icon('heroicon-o-wrench')
                ->requiresConfirmation()
                ->color('primary'),
            Actions\Action::make('viewPdf')
                ->label('Ver PDF')
                ->url(fn (Manual $record) => Storage::url($record->file))
                ->icon('heroicon-o-eye')
                ->openUrlInNewTab()
                ->visible(fn (Manual $record): bool => !empty($record->file)),
            Actions\Action::make('deletePdf')
                ->label('Eliminar PDF')
                ->action(function (Manual $record) {
                    if (!empty($record->file)) {
                        Storage::delete($record->file);
                        $record->file = null;
                        $record->save();

                        Notification::make()
                            ->title('PDF eliminado')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('No hay PDF para eliminar')
                            ->danger()
                            ->send();
                    }
                })
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->color('danger')
                ->visible(fn (Manual $record): bool => !empty($record->file)),
        ];

    }
}
