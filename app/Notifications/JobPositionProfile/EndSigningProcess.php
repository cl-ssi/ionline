<?php

namespace App\Notifications\JobPositionProfile;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\JobPositionProfiles\JobPositionProfile;

class EndSigningProcess extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobPositionProfile $jobPositionProfile)
    {
        $this->jobPositionProfile = $jobPositionProfile;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // return [
        //     'module'  => 'Perfil de Cargos', // Opcional
        //     'icon'    => '<i class="fas fa-id-badge fa-fw"></i>',
        //     'subject' => 'Se ha completado aprobación de Perfil de Cargo, ID: '.$this->jobPositionProfile->id,
        //     'action'  => route('job_position_profile.show', [$this->jobPositionProfile], false),
        // ];

        return [
            "actions" => [
                [
                    "name" => "view_job_position_profile",
                    "label" => "Ver Perfil de Cargo",
                    "url" => route('job_position_profile.show', [$this->jobPositionProfile], false), 
                    "color" => "primary",
                    "icon" => "heroicon-o-eye",
                    "shouldOpenInNewTab" => true,
                ],
            ],
            "body" => 'El proceso de aprobación del perfil de cargo ha finalizado.',
            "color" => "success",
            "duration" => "persistent",
            "icon" => "heroicon-o-check-circle",
            "iconColor" => "green",
            "status" => "success",
            "title" => 'Aprobación Finalizada',
            "view" => "filament-notifications::notification",
            "format" => "filament",
        ];
    }
}
