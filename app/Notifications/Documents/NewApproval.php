<?php

namespace App\Notifications\Documents;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Documents\Approval;

class NewApproval extends Notification
{
    use Queueable;

    public $approval;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Approval $approval)
    {
        $this->approval = $approval;
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
        //     'module'  => $this->approval->module,
        //     'icon'    => '<i class="fa-fw '.$this->approval->module_icon.'"></i>', 
        //     'subject' => $this->approval->subject,
        //     'action' => route('documents.approvals',[$this->approval->id], false),
        // ];

        //if module_icon is a string with two words, store the last word in $icon var
        $moduleIconParts = explode(' ', $this->approval->module_icon);
        $icon = end($moduleIconParts);

        return [
            "title" => ucfirst($this->approval->module), // Modulo
            "body" => $this->approval->subject, // Subject
            "icon" => $icon, // Generar dinámicamente el ícono
            // "status" => "info", 
            "actions" => [
                [
                    "icon" => "heroicon-o-document", 
                    "color" => "primary", 
                    "label" => "Ver Aprobación", 
                    "url" => route('documents.approvals', [$this->approval->id], false), 
                    "shouldOpenInNewTab" => true, 
                    "name" => str_replace('\\', '_', get_class($this)), 
                ],
            ],
            "format" => "filament", 
            "duration" => "persistent", 
            // "view" => "filament-notifications::notification", 
        ];
        
    }
}
