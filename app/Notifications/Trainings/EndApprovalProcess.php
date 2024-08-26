<?php

namespace App\Notifications\Trainings;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Trainings\Training;
use Illuminate\Support\HtmlString;

class EndApprovalProcess extends Notification
{
    use Queueable;

    public $training;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Training $training)
    {
        $this->training = $training;
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
        /*
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
        */

        dd('aquí en la notification', $notifiable,  $this->training);

        return (new MailMessage)
                    ->level('info')
                    ->replyTo(env('APP_RYS_MAIL'))
                    ->subject('Primera Prueba')
                    ->greeting('Hola ' . $notifiable->shortName)
                    ->line(new HtmlString('Se ha <b>CANCELADO</b> una reserva en <b>' . $roomBooking->room->identifier . '</b> en el complejo <b>' . $roomBooking->room->hotel->name . '</b>.'))
                    ->line(new HtmlString('Motivo: ' . $roomBooking->cancelation_observation))
                    ->line(new HtmlString('Para conocer los detalles de la cancelación, ingrese al módulo de reservas o bien contácte al área de bienestar.'))
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
