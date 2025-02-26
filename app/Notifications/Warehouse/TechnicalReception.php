<?php

namespace App\Notifications\Warehouse;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class TechnicalReception extends Notification
{
    use Queueable;

    public $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
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
        //     'icon'    => '<i class="fas fa-fw fa-box-open"></i>',
        //     'subject' => 'Firma pendiente de '. $this->subject,
        //     'action' => route('documents.signatures.index',['pendientes'], false),
        // ];

        return [
            "icon" => "heroicon-o-inbox",
            "status" => "info", //Color del icono
            "title" => 'Firma Pendiente',
            "body" => 'Firma pendiente de ' . $this->subject,
            "actions" => [
                [
                    "name" => "sign_document",
                    "label" => "Firmar Documento",
                    "url" => route('documents.signatures.index', ['pendientes']),   
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
