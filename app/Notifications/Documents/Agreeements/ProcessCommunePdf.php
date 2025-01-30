<?php

namespace App\Notifications\Documents\Agreeements;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcessCommunePdf extends Notification implements ShouldQueue
{
    use Queueable;

    protected $record;

    public function __construct($record)
    {
        $this->record = $record;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Generar el PDF usando la misma vista que usas para visualizar
        $pdf = Pdf::loadView('documents.agreements.processes.view', [
            'record' => $this->record,
            // Aquí puedes agregar más variables que necesites en la vista
        ]);

        return (new MailMessage)
                    ->subject('Solicita firma de comuna - proceso comunal')
                    ->greeting('Hola!')
                    ->line('Se solicita firma de documento por parte de la autoridad comunal.')
                    ->line('Adjunto al correo va el PDF en referencia.')
                    ->line('Una vez firmado debe ser cargado en la plataforma.')
                    // ->action('Ver Proceso', route('documents.agreements.processes.view', [$this->record]))
                    // ->line('Gracias por usar nuestra aplicación!')
                    ->attachData($pdf->output(), 'proceso_' . $this->record->id . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }

    public function toArray($notifiable)
    {
        return [
            'record_id' => $this->record->id,
            'message' => 'Se ha creado un nuevo proceso comunal.',
        ];
    }
}