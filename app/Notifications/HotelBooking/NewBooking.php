<?php

namespace App\Notifications\HotelBooking;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Parameters\Parameter;
use Carbon\Carbon;

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
        $appUrl = config('app.url');

        $roomBooking = $this->roomBooking;
        return (new MailMessage)
                    ->level('info')
                    ->replyTo($cc_mails)
                    ->subject('Se ha realizado una nueva reserva!')
                    ->greeting('Hola ' . $notifiable->shortName)
                    ->line(new HtmlString('Se ha realizado una nueva reserva en <b>' . $roomBooking->room->identifier . '</b> en el complejo <b>' . $roomBooking->room->hotel->name . '</b>.'))
                    ->line(new HtmlString('El valor de la reserva es <b>$' . (int) $roomBooking->start_date->diffInDays($roomBooking->end_date) * $roomBooking->room->price . '</b>.'))
                    ->line(new HtmlString('El check-in es para el día  <b>' . $roomBooking->start_date->format('Y-m-d') . '</b> a partir de las 18:00 hrs.'))
                    ->line(new HtmlString('El check-out es para el día  <b>' . $roomBooking->end_date->format('Y-m-d') . '</b> a partir de las 17:00 hrs.'))
                    ->line(new HtmlString('El tipo de pago seleccionado es <b>' . $roomBooking->payment_type . '</b>.'))
                    ->line(new HtmlString('Si el tipo de pago es transferencia, tiene 5 horas para ingresar a la aplicación y subir el comprobante de transferencia. Si no realiza esto dentro del período indicado, la hora se anulará y quedará disponible para otros funcionarios.'))
                    ->line(new HtmlString('<i><b><span style="color:red; font-size:16px;">Importante:</span></b> Su reserva <b>no está confirmada</b> aún. Está sujeta a la revisión y aprobación del área de bienestar. Le notificaremos una vez que haya sido confirmada.</i>'))
                    ->action('Revisa tus reservas aquí', $appUrl . '/hotel_booking/my_bookings')
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
