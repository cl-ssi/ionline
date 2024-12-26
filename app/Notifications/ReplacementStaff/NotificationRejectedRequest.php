<?php

namespace App\Notifications\ReplacementStaff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\ReplacementStaff\RequestReplacementStaff;

class NotificationRejectedRequest extends Notification
{
    use Queueable;

    public $requestReplacementStaff;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RequestReplacementStaff $requestReplacementStaff, $to)
    {
        $this->requestReplacementStaff = $requestReplacementStaff;
        $this->to = $to;
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
        // if($this->to == 'reclutamiento'){
        //     $action = 'replacement_staff.request.technical_evaluation.show';
        // }
        // else{
        //     $action = 'replacement_staff.request.technical_evaluation.show';
        // }

        // return [
        //     'module'  => 'Solicitudes de Contratación',
        //     'icon'    => '<i class="far fa-id-card"></i>',
        //     'subject' => 'Se ha rechazado la solicitud ID: '.$this->requestReplacementStaff->id.' click más información',
        //     'action'  => route($action, $this->requestReplacementStaff->id, false)
        // ];

        
        return [
            "icon" => "heroicon-o-x-circle",
            "status" => "error", 
            "title" => "Solicitudes de Contratación", 
            "body" => "Se ha rechazado la solicitud ID: {$this->requestReplacementStaff->id}. Haz clic en el botón para más información.", 
            "actions" => [
                [
                    "name" => "view_request",
                    "label" => "Ver Solicitud", 
                    "url" => route('replacement_staff.request.technical_evaluation.show', $this->requestReplacementStaff->id, false),
                    "color" => "primary", 
                    "icon" => "heroicon-o-eye", 
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
