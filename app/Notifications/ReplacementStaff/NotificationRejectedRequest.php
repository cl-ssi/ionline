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
        if($this->to == 'reclutamiento'){
            $action = 'replacement_staff.request.technical_evaluation.show';
        }
        else{
            $action = 'replacement_staff.request.technical_evaluation.show';
        }

        return [
            'module'  => 'Solicitudes de Contratación',
            'icon'    => '<i class="far fa-id-card"></i>',
            'subject' => 'Se ha rechazado la solicitud ID: '.$this->requestReplacementStaff->id.' click más información',
            'action'  => route($action, $this->requestReplacementStaff->id, false)
        ];
    }
}
