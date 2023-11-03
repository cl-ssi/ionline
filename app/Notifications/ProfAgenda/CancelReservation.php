<?php

namespace App\Notifications\ProfAgenda;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use App\Models\ProfAgenda\OpenHour;

class CancelReservation extends Notification implements ShouldQueue
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
            ->subject('Cancelación de reserva con '. $this->openHour->activityType->name . ' el ' . $this->openHour->start_date->format('Y-m-d'))
            ->greeting('Hola ' . $notifiable->shortName)
            ->line('Lamentablemente la reserva que tenía el para ' . $this->openHour->start_date->format('Y-m-d') . ' a las ' . $this->openHour->start_date->format('H:s') . ' con el profesional ' . $this->openHour->profesional->shortName . ' ha sido cancelada por fuerza mayor y no podrá ser atendido.')
            ->line('Disculpando las molestias y en caso que siga requiriendo la atención, se le solicita pueda llamar (575767) o acercarse a nuestra unidad para reagendar.')
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
