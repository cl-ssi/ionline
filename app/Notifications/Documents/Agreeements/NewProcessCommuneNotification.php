<?php

namespace App\Notifications\Documents\Agreeements;

// use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource;
use App\Filament\Extranet\Resources\ProcessResource;
use App\Models\Documents\Agreements\Process;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProcessCommuneNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Process $process;

    /**
     * Create a new notification instance.
     */
    public function __construct(Process $process)
    {
        $this->process = $process;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Use the correct panel ID (extranet) in the URL generation
        $url = ProcessResource::getUrl('edit', ['record' => $this->process], panel: 'extranet');
        
        return (new MailMessage)
            ->level('info')
            ->subject('Proceso para revisión ' . $this->process->id)
            ->greeting('Estimado/a')
            ->line('Nuevo proceso para revisión Nº: ' . $this->process->id)
            ->action('Ver Proceso ' . $this->process->id, $url)
            ->salutation('Saludos cordiales.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}