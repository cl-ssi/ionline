<?php

namespace App\Notifications\ProfAgenda;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\ProfAgenda\OpenHour;

class NewReservation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $openHour;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(OpenHour $openHour)
    {
        $this->openHour = $openHour;
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
        return (new MailMessage)
            ->level('info')
            ->subject('UST - Cita con '. $this->openHour->activityType->name . ' el ' . $this->openHour->start_date->format('Y-m-d'))
            ->greeting('Hola ' . $notifiable->shortName)
            ->line('Se ha reservado una hora de: ' . $this->openHour->activityType->name)
            ->line('Con el profesional: ' . $this->openHour->profesional->shortName)
            ->line('La reserva se encuentra realizada para: ' . $this->openHour->start_date->format('Y-m-d'). ' a las: ' . $this->openHour->start_date->format('H:i'))
            ->line('Se solicita llegar puntual a su hora.')
            
            // ->action('Ver Requerimiento (SGR) ' . $this->sgr->id, route('requirements.show', $this->sgr->id) )
            ->line(' Si no puede asistir, rogamos contactar a la Unidad de Salud del Trabajador para reagendar o cancelar su hora.')
            ->salutation('Saludos cordiales.');
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
            //
        ];
    }
}
