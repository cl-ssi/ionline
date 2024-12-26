<?php

namespace App\Notifications\ReplacementStaff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\ReplacementStaff\RequestReplacementStaff;

class NotificationFinanceElectronicSign extends Notification
{
    use Queueable;

    public $requestReplacementStaff;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RequestReplacementStaff $requestReplacementStaff)
    {
        $this->requestReplacementStaff  = $requestReplacementStaff;
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
        //     'module'  => 'Solicitudes de Contratación', // Opcional
        //     'icon'    => '<i class="far fa-id-card"></i>',
        //     'subject' => 'Nueva solicitud de firma electrónica para reemplazo ID: '.$this->requestReplacementStaff->id,
        //     'action'  => route('documents.signatures.index', 'pendientes', false)
        // ];

        return [
            "icon" => "heroicon-o-identification", 
            "status" => "info", 
            "title" => 'Solicitudes de Contratación', 
            "body" => 'Se ha creado una nueva solicitud de firma electrónica para el reemplazo ID: '.$this->requestReplacementStaff->id,
            "actions" => [
                [
                    "name" => "view_request",
                    "label" => "Ver Solicitud", 
                    "url" => route('documents.signatures.index', 'pendientes', false),
                    "color" => "primary",
                    "icon" => "heroicon-o-document", 
                    "shouldOpenInNewTab" => true, 
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
