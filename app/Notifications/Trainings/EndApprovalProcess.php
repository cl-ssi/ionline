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
        return (new MailMessage)
                    ->level('info')
                    ->replyTo($this->training->email)
                    ->subject('[Notificación] Adjuntar certificado final de la actividad')
                    ->greeting('Hola, ' . $this->training->userTraining->FullName)
                    ->line(new HtmlString('<p style="text-align: justify;">Espero que se encuentre bien. Le escribo para recordarle que ha finalizado el periodo de la actividad <b>'
                        .$this->training->activity_name. '</b>, según el registro de fechas consignado en el formulario de capacitación realizado y 
                        aprobado en nuestro sistema (inicio: '.$this->training->activity_date_start_at.' , fin: '.$this->training->activity_date_end_at.'). 
                        Es fundamental que complete el proceso de adjuntar el certificado final de la actividad mediante el sistema i-online. </p>'))
                    ->line(new HtmlString('<p style="text-align: justify;">El cumplimiento de este plazo es obligatorio, ya que nos permite mantener actualizados los registros de sus capacitaciones en SIRH y su historial de actividades.</p>'))
                    ->line(new HtmlString('<p style="text-align: justify;">Por favor, le solicitamos que realice este procedimiento antes de transcurridos 20 días hábiles desde la fecha de término de la actividad.</p>'))
                    ->line(new HtmlString('<p style="text-align: justify;">Para cualquier pregunta o asistencia adicional, no dude en contactarnos.</p>'))
                    ->line(new HtmlString('Unidad de Formación y Capacitación <br>
                        Departamento de Gestión y Desarrollo del Talento <br>
                        Servicio de Salud Tarapacá'))                    
                    ->cc(env('APP_RYS_MAIL'))
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
