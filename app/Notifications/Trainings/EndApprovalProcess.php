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
        if($this->training->user_creator_id == null){
            $link = 'https://i.saludtarapaca.gob.cl/login/external';
        }
        else{
            $link = 'https://i.saludtarapaca.gob.cl/';
        }
        
        return (new MailMessage)
                    ->level('info')
                    ->replyTo($this->training->email)
                    ->subject('[Notificación] Adjuntar certificado final de la actividad')
                    ->greeting('Hola, ' . $this->training->userTraining->fullName)
                    ->line(new HtmlString('<p style="text-align: justify;">Espero que se encuentre muy bien.</p>'))
                    ->line(new HtmlString('<p style="text-align: justify;">Queremos agradecerle por participar en la actividad 
                        <b>'.$this->training->activity_name.'</b>. Nos complace que haya sido parte de esta experiencia 
                        de aprendizaje, y esperamos que haya sido enriquecedora tanto personal como profesionalmente.</p>'))
                    ->line(new HtmlString('<p style="text-align: justify;">Le recordamos que, según el registro de fechas consignado 
                        en el formulario de capacitación realizado y aprobado en nuestro sistema, la actividad ha concluido. Para 
                        completar este proceso y asegurar que todo quede registrado adecuadamente, es necesario que adjunte el certificado 
                        final de la actividad a través del sistema i-online. Puede hacerlo fácilmente en el siguiente 
                        <a href="'.$link.'">enlace</a>.</p>'))
                    ->line(new HtmlString('<p style="text-align: justify;">Es importante que realice esta acción dentro de los próximos 
                        20 días hábiles a partir de la fecha de término de la actividad ('.$this->training->activity_date_end_at->format('d-m-Y').'). 
                        El cumplimiento de este plazo es obligatorio, ya que es responsabilidad del funcionario o funcionaria mantener 
                        actualizados los registros de sus capacitaciones en SIRH. (Fecha límite: '.$this->training->addBusinessDays($this->training->activity_date_end_at, 20)->format('d-m-Y').').</p>'))
                    ->line(new HtmlString('<p style="text-align: justify;">Si tiene alguna pregunta o necesita asistencia, no dude en 
                        ponerse en contacto con nosotros. Estamos aquí para ayudarle.</p>'))
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
