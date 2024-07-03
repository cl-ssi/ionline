<?php

namespace App\Notifications\HotelBooking;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Parameters\Parameter;

use Illuminate\Support\HtmlString;

use App\Models\HotelBooking\RoomBooking;

class BookingConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $roomBooking;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RoomBooking $roomBooking)
    {
        $this->roomBooking = $roomBooking;
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
        $cc_mails = explode(', ', Parameter::get('welfare: cabañas','correos confirmado'));

        $roomBooking = $this->roomBooking;
        return (new MailMessage)
                    ->level('info')
                    ->replyTo($cc_mails)
                    ->subject('Se ha confirmado una reserva')
                    ->greeting('Hola ' . $notifiable->shortName)
                    ->line(new HtmlString('Se ha <b>CONFIRMADO</b> una reserva en <b>' . $roomBooking->room->identifier . '</b> en el complejo <b>' . $roomBooking->room->hotel->name . '</b>.'))
                    ->line(new HtmlString('El check-in es para el día  <b>' . $roomBooking->start_date->format('Y-m-d') . '</b> a partir de las 18:00 hrs.'))
                    ->line(new HtmlString('El check-out es para el día  <b>' . $roomBooking->end_date->format('Y-m-d') . '</b> a partir de las 17:00 hrs.'))
                    ->line(new HtmlString('Se informa que si no asiste a la reserva, solo podrá optar a una devolución del 50% del monto pactado.'))
                    ->line(new HtmlString('Email contacto de encargado del hospedaje: ' . $roomBooking->room->hotel->manager_email))
                    ->line(new HtmlString('Teléfono contacto de encargado del hospedaje: ' . $roomBooking->room->hotel->manager_phone))
                    ->cc($cc_mails)
                    ->salutation('Saludos cordiales');
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
