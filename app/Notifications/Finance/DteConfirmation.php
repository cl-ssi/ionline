<?php

namespace App\Notifications\Finance;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Finance\Dte;

class DteConfirmation extends Notification
{
    use Queueable;

    // public $dte;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Dte $dte)
    {
        $this->dte = $dte;
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
        return [
            // 'module'  => 'Prueba', // Opcional
            'icon'    => '<i class="fas fa-fw fa-file-invoice-dollar"></i>', // Opcional
            'subject' => 'Nueva DTE para confirmar: '.$this->dte->id,
            'action' => route('finance.dtes.confirmation',[$this->dte], false),
        ];
    }
}
