<?php

namespace App\Notifications\ProfAgenda;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use App\Models\ProfAgenda\OpenHour;
use Illuminate\Support\HtmlString;

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
            ->replyTo('unidadstrabajador@gmail.com')
            ->subject('Cancelación de reserva con '. $this->openHour->activityType->name . ' el ' . $this->openHour->start_date->format('Y-m-d'))
            ->greeting('Hola ' . $notifiable->shortName)
            ->line('Lamentablemente la reserva que tenía el para ' . $this->openHour->start_date->format('Y-m-d') . ' a las ' . $this->openHour->start_date->format('H:s') . ' con el profesional ' . $this->openHour->profesional->shortName . ' ha sido cancelada por fuerza mayor y no podrá ser atendido.')
            ->line('Disculpando las molestias y en caso que siga requiriendo la atención, rogamos contactar o acercarse a nuestra unidad para reagendar.')
            ->line(new HtmlString('<hr>'))
            // ->line(new HtmlString('<small><i>Si no puede asistir, rogamos contactar a la Unidad de Salud del Trabajador para reagendar o cancelar su hora.</i></small>'))
            ->line(new HtmlString('<small><i>N° Telefono: 575767 / +57 2 405766</i></small>'))
            ->line(new HtmlString('<small><i>Correo electrónico: unidadstrabajador@gmail.com</i></small>'))
            ->line(new HtmlString('<small>Este correo se genera de forma automática, <b>FAVOR NO RESPONDER</b>.</small><br><hr>'))
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
