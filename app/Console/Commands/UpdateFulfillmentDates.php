<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\ServiceRequests\ServiceRequest;
use Carbon\Carbon;

class UpdateFulfillmentDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fulfillments:update-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar las fechas de start_date y end_date de los Fulfillments basadas en el ServiceRequest asociado cuando tengan fecha 0000-00-00 00:00:00';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener los Fulfillments que tengan fechas como '0000-00-00 00:00:00'
        $fulfillments = Fulfillment::where('start_date', '0000-00-00 00:00:00')
            ->orWhere('end_date', '0000-00-00 00:00:00')
            ->get();

        foreach ($fulfillments as $fulfillment) {
            // Obtener el ServiceRequest asociado
            $serviceRequest = ServiceRequest::find($fulfillment->service_request_id);

            // Verificar que el ServiceRequest exista
            if (!$serviceRequest) {
                $this->error("ServiceRequest no encontrado para Fulfillment ID: {$fulfillment->id}");
                continue;
            }

            // Calcular las nuevas fechas de inicio y fin basadas en year y month del fulfillment
            $year = $fulfillment->year;
            $month = $fulfillment->month;

            // Definir las nuevas fechas
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth()->setTime(0, 0, 0); // Establecer la hora 00:00:00

            // Asegurarse de que las fechas estén dentro del rango del ServiceRequest
            if ($startDate < $serviceRequest->start_date) {
                $startDate = $serviceRequest->start_date;
            }
            if ($endDate > $serviceRequest->end_date) {
                $endDate = $serviceRequest->end_date->setTime(0, 0, 0); // Mantener la hora 00:00:00
            }

            // Actualizar las fechas en el Fulfillment
            $fulfillment->start_date = $startDate;
            $fulfillment->end_date = $endDate;
            $fulfillment->save();

            $this->info("Fechas actualizadas para Fulfillment ID: {$fulfillment->id}");
        }

        return 0;
    }
}
