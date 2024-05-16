<?php

namespace App\Notifications\Sirh;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class PendingJsonToInsertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $message;
    private $output;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $output = null)
    {
        $this->message = $message;
        $this->output = $output;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
                    ->subject('Integración automática - Sirh/Ionline')
                    ->line($this->message);

        if ($this->output) {
            $mailMessage->line('Artisan Command Output:')
                        ->line($this->output);
        }

        return $mailMessage->line('No responder este correo.');
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
            'message' => $this->message,
            'output' => $this->output,
        ];
    }
}