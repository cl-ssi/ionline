<?php

namespace App\Notifications\Allowances;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Allowances\Allowance;

class NewAllowance extends Notification
{
    use Queueable;

    public $allowance;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Allowance $allowance)
    {
        $this->allowance = $allowance;
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
        //     'module'  => 'Víaticos', // Opcional
        //     'icon'    => '<i class="bi bi-wallet"></i>',
        //     'subject' => 'Se ha creado una nueva solicitud de viático ID: '.$this->allowance->id,
        //     'action'  => route('allowances.show', $this->allowance->id, false)
        // ];

        return [
            "icon" => "heroicon-o-wallet",
            "status" => "info",
            "title" => 'Víaticos',
            "body" => 'Se ha creado una nueva solicitud de viático con el ID: '.$this->allowance->id,
            "actions" => [
                [
                    "name" => "view_allowance",
                    "label" => "Ver Solicitud de Viático",
                    "url" => route('allowances.show', $this->allowance->id, false),
                    "color" => "primary",
                    "icon" => "heroicon-o-eye",
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
