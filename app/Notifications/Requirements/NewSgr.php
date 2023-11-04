<?php

namespace App\Notifications\Requirements;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Requirements\Requirement;
use App\Models\Requirements\Event;

class NewSgr extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sgr;
    protected $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Requirement $sgr, Event $event)
    {
        $this->sgr = $sgr;
        $this->event = $event;
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
            ->subject('Requerimiento Nº: ' . $this->sgr->id)
            ->greeting('Hola ' . $this->event->to_user->name)
            ->line('Nuevo requerimiento Nº: ' . $this->sgr->id)
            ->line('Asunto: ' . $this->sgr->subject)
            ->line('Detalle: ' . $this->event->body)
            ->line('Creador: ' . $this->sgr->user->shortName)
            ->lineIf( !is_null($this->sgr->user->organizational_unit_id), 'Unidad Organizacional: ' . $this->sgr->user->organizationalUnit?->name)
            ->action('Ver Requerimiento (SGR) ' . $this->sgr->id, route('requirements.show', $this->sgr->id) )
            ->lineIf(!is_null($this->sgr->limit_at),'Fecha límite: : '. $this->sgr->limit_at)
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
