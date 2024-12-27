<?php

namespace App\Notifications\Documents;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Documents\Signature;

class PendingSign extends Notification
{
    use Queueable;

    public $signature;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Signature $signature)
    {
        $this->signature = $signature;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // return [
        //     // 'module'  => 'Prueba', // Opcional
        //     'module'  => 'Firma',
        //     'icon'    => '<i class="fas fa-bell"></i>', // Opcional
        //     'subject' => 'El Usuario '.auth()->user()->tinny_name.' le recuerda Firmar/Visar la Solicitud de Firma '.$this->signature->id, 
        //     'action' => route('documents.signatures.index',['pendientes'], false),
        // ];

        return [
            "icon" => "heroicon-o-bell",
            "status" => "info",
            "title" => 'Firma',
            "body" => 'El Usuario ' . auth()->user()->tinny_name . ' le recuerda Firmar/Visar la Solicitud de Firma ' . $this->signature->id,
            "actions" => [
                [
                    "name" => "view_pending_signatures",
                    "label" => "Firmar/Visar Solicitud",
                    "url" => route('documents.signatures.index', ['pendientes'], false), 
                    "color" => "primary",
                    "icon" => "heroicon-o-pencil",
                    "shouldOpenInNewTab" => false,
                    "shouldMarkAsRead"=> true, // Marcar como leída al hacer clic
                    "view"=> "filament-actions::button-action",
                ],
            ],
            "duration" => "persistent",
            "view" => "filament-notifications::notification",
            "format" => "filament",
        ];
    }
}
