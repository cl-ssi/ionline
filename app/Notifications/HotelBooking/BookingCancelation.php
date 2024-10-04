<?php

namespace App\Notifications\HotelBooking;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Parameters\Parameter;

use Illuminate\Support\HtmlString;

use App\Models\HotelBooking\RoomBooking;

class BookingCancelation extends Notification implements ShouldQueue
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
        $cc_mails = explode(', ', Parameter::get('welfare: cabañas','correos anulación'));

        $roomBooking = $this->roomBooking;
        return (new MailMessage)
                    ->level('info')
                    ->replyTo($cc_mails)
                    ->subject('Se ha anulado una reserva')
                    ->greeting('Hola ' . $notifiable->shortName)
                    ->line(new HtmlString('Se ha <b>ANULADO</b> una reserva en <b>' . $roomBooking->room->identifier . '</b> en el complejo <b>' . $roomBooking->room->hotel->name . '</b>.'))
                    ->line(new HtmlString('Motivo: ' . $roomBooking->cancelation_observation))
                    ->line(new HtmlString('Para conocer los detalles de la anulación, ingrese al módulo de reservas o bien contácte al área de bienestar.'))
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
