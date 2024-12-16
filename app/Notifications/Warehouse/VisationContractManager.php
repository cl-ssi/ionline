<?php

namespace App\Notifications\Warehouse;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisationContractManager extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        
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
        //     //
        //     'module'  => 'Visaciones Pendiente', // Opcional
        //     'icon'    => '<i class="fas fa-question-circle"></i>', // Opcional
        //     'subject' => 'Tiene una nueva solicitud de visacion por parte de boedega  para su formulario de requerimiento, por favor acceda ',
        //     'action' => route('warehouse.visation_contract_manager.index'),
        // ];

        return [
            "actions" => [
                [
                    "name" => "view_pending_visations",
                    "label" => "Ver Visaciones Pendientes", 
                    "url" => route('warehouse.visation_contract_manager.index'),
                    "color" => "primary", 
                    "icon" => "heroicon-o-eye", 
                    "shouldOpenInNewTab" => false, 
                ],
            ],
            "body" => 'Tiene una nueva solicitud de visación por parte de bodega para su formulario de requerimiento. Por favor acceda .', 
            "color" => "info", 
            "duration" => "persistent", 
            "icon" => "heroicon-o-question-mark-circle", 
            "iconColor" => "blue", 
            "status" => "info", 
            "title" => 'Visaciones Pendientes', 
            "view" => "filament-notifications::notification", 
            "format" => "filament", 
        ];
        
    }
}
