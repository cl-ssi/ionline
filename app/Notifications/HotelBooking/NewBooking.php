<?php

namespace App\Notifications\HotelBooking;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Parameters\Parameter;

use Illuminate\Support\HtmlString;

use App\Models\HotelBooking\RoomBooking;

class NewBooking extends Notification implements ShouldQueue
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
        $cc_mails = explode(', ', Parameter::get('welfare: cabañas','correos solicitudes'));

        $roomBooking = $this->roomBooking;
        return (new MailMessage)
                    ->level('info')
                    ->subject('Se ha realizado una nueva reserva')
                    ->greeting('Hola ' . $notifiable->shortName)
                    ->line(new HtmlString('Se ha realizado una nueva reserva en <b>' . $roomBooking->room->identifier . '</b> en el complejo <b>' . $roomBooking->room->hotel->name . '</b>.'))
                    ->line(new HtmlString('El check-in es para el día  <b>' . $roomBooking->start_date->format('Y-m-d') . '</b> a partir de las 18:00 hrs.'))
                    ->line(new HtmlString('El check-out es para el día  <b>' . $roomBooking->end_date->format('Y-m-d') . '</b> a partir de las 17:00 hrs.'))
                    ->line(new HtmlString('El tipo de pago seleccionado es <b>' . $roomBooking->payment_type . '</b>.'))
                    ->line(new HtmlString('Si el tipo de pago es depósito, favor ingresar a la aplicación y subir el comprobante de transferencia.'))
                    ->line(new HtmlString('<br>'))
                    ->line(new HtmlString('<i>La reserva se encuentra en revisión, y sera confirmada por el área de bienestar.</i>'))
                    ->cc($cc_mails)
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
