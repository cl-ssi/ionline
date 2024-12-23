<?php

namespace App\Notifications\Rrhh;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Rrhh\PerformanceReport;


class NewPerformanceReport extends Notification
{
    use Queueable;
    protected $performanceReport;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PerformanceReport $performanceReport)
    {
        //
        $this->performanceReport = $performanceReport;
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
            ->subject('Calificación periodo: ' . $this->performanceReport->period->name. ' -  para Funcionario: ' .$this->performanceReport->receivedUser->tinyName )
            ->greeting('Hola ' . $this->performanceReport->receivedUser->shortName)
            ->line('Se Informa que se encuentra disponible su informe de calificación, correspondiente al periodo:' . $this->performanceReport->period->name)
            ->action('Revisar Informe de Calificación', route('rrhh.performance-report.received_report') )
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
