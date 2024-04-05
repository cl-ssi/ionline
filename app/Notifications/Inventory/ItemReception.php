<?php

namespace App\Notifications\Inventory;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Inv\InventoryMovement;

class ItemReception extends Notification implements ShouldQueue
{
    use Queueable;

    protected $movement;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(InventoryMovement $movement)
    {
        $this->movement = $movement;
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
            ->subject('Recepcionar Item Nº: ' . $this->movement->inventory->number)
            ->greeting('Hola ' . $notifiable->shortName)
            ->line('Se informa traspaso de bien inventariable, código de inventario N°' . $this->movement->inventory->number)
            // ->line('Item: ' . ($this->movement->inventory->product_id) ? $this->movement->inventory->product->name : $this->movement->inventory->unspscProduct->name)
            ->line('Estado: ' . $this->movement->inventory->estado)
            ->lineIf( !is_null( $this->movement->user_sender_id), 'Entregado por: ' . $this->movement->senderUser?->shortName)
            ->action('Ir a Movimientos Pendientes', route('inventories.pending-movements') )
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
