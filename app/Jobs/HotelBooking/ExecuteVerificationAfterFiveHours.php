<?php

namespace App\Jobs\HotelBooking;

use App\Models\HotelBooking\RoomBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\HotelBooking\BookingCancelation;

class ExecuteVerificationAfterFiveHours implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $roomBooking;

    /**
     * Create a new job instance.
     */
    public function __construct(RoomBooking $roomBooking)
    {
        $this->roomBooking = $roomBooking;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Verificar si el payment_type es "Transferencia" y el status es "Reservado"
        if ($this->roomBooking->payment_type === 'Transferencia' && $this->roomBooking->status === 'Reservado') {
            // Verificar si tiene archivos asociados
            if ($this->roomBooking->files()->count() === 0) {
                // Actualizar el status a "Cancelado" y agregar observación de cancelación
                $this->roomBooking->status = 'Cancelado';
                $this->roomBooking->cancelation_observation = 'La reserva fue anulada automáticamente porque no se subió el comprobante de transferencia dentro de las 5 horas después de realizar la reserva.';
                
                // Guardar los cambios en el modelo
                $this->roomBooking->save();

                $this->roomBooking->user->notify(new BookingCancelation($this->roomBooking));
            }
        }
    }
}
