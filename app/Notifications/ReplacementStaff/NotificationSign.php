<?php

namespace App\Notifications\ReplacementStaff;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ReplacementStaff\RequestReplacementStaff;

class NotificationSign extends Notification
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
        $this->requestReplacementStaff = $requestReplacementStaff;
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
        //     'subject' => 'Nueva Solicitud para Aprobación ID: '.$this->requestReplacementStaff->id,
        //     'action'  => route('replacement_staff.request.to_sign', $this->requestReplacementStaff->id, false),
        // ];

        return [
            "icon" => "heroicon-o-identification",  
            "status" => "info", 
            "title" => 'Solicitudes de Contratación', 
            "body" => 'Nueva solicitud de contratación para aprobación. ID: '.$this->requestReplacementStaff->id,
            "actions" => [
                [
                    "name" => "view_replacement_request",
                    "label" => "Ver Solicitud de Contratación", 
                    "url" => route('replacement_staff.request.to_sign', $this->requestReplacementStaff->id),
                    "color" => "primary", 
                    "icon" => "heroicon-o-document-text", 
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
