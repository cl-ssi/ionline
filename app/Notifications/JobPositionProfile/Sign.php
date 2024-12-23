<?php

namespace App\Notifications\JobPositionProfile;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\JobPositionProfiles\JobPositionProfile;

class Sign extends Notification
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
        //     'subject' => 'Nuevo Perfil de Cargo para Aprobación, ID: '.$this->jobPositionProfile->id,
        //     'action'  => route('job_position_profile.to_sign', [$this->jobPositionProfile], false),
        // ];

        return [
            "actions" => [
                [
                    "name" => "approve_job_position_profile",
                    "label" => "Aprobar Perfil de Cargo", 
                    "url" => route('job_position_profile.to_sign', [$this->jobPositionProfile], false), 
                    "color" => "primary", 
                    "icon" => "heroicon-o-check", 
                    "shouldOpenInNewTab" => true, 
                ],
            ],
            "body" => 'Se ha creado un nuevo perfil de cargo para aprobación. Revisa los detalles y realiza las acciones correspondientes.', 
            "color" => "info", 
            "duration" => "persistent", 
            "icon" => "heroicon-o-user-circle",
            "iconColor" => "blue", 
            "status" => "info", 
            "title" => 'Nuevo Perfil de Cargo para Aprobación', 
            "view" => "filament-notifications::notification", 
            "format" => "filament", 
        ];
        
    }
}
