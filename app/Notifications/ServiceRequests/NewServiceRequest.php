<?php

namespace App\Notifications\ServiceRequests;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

use App\Models\ServiceRequests\ServiceRequest;

class NewServiceRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $serviceRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
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
            ->subject("Se ha creado la solicitud de contratación de honorarios nro. ".$this->serviceRequest->id)
            ->greeting('Hola ' . $notifiable->shortName)
            ->line('Junto con saludar cordialmente.')
            ->line('Se informa que la solicitud de contratación de honorarios nro ' . $this->serviceRequest->id . ' se encuentra disponible para su visación.')
            ->line('Tipo: ' . $this->serviceRequest->type)
            ->line('Fecha solicitud: ' . $this->serviceRequest->request_date->format('d-m-Y'))
            ->line('Rut: ' . $this->serviceRequest->employee->runFormat())
            ->line('Funcionario: ' . $this->serviceRequest->employee->getFullNameAttribute())
            ->line('Fecha inicio: ' . $this->serviceRequest->start_date->format('d-m-Y'))
            ->line('Fecha término: ' . $this->serviceRequest->end_date->format('d-m-Y'))
            ->line('')

            //Para acceder y visar la solicitud, haga click <a href="https://i.saludtarapaca.gob.cl/rrhh/service_requests/{{$this->serviceRequest->id}}/edit"><i class="far fa-hand-point-right"></i> Aquí</a>
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
