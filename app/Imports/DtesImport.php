<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use App\Models\Finance\Dte;
use App\Models\Finance\PurchaseOrder\Prefix;
use App\Models\Finance\PurchaseOrder;
use App\Notifications\Finance\DteConfirmation;
use App\Models\User;


class DtesImport implements ToModel, WithStartRow, WithHeadingRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //TODO fixear cuando de acepta no traigan OC y no borre lo que ya se digitó

        $array_clave =
        [
            'tipo' => $row['tipo'],
            'tipo_documento' => $row['tipo_documento'],
            'folio' => $row['folio'],
            'emisor' => trim($row['emisor']),
        ];

        $array_variable =
        [
            'razon_social_emisor' => $row['razon_social_emisor'],
            'receptor' => $row['receptor'],
            'publicacion' => Carbon::instance(Date::excelToDateTimeObject($row['publicacion'])),
            'emision' => Carbon::instance(Date::excelToDateTimeObject($row['emision'])),
            'monto_neto' => $row['monto_neto'],
            'monto_exento' => $row['monto_exento'],
            'monto_iva' => $row['monto_iva'],
            'monto_total' => $row['monto_total'],
            'impuestos' => $row['impuestos'],
            'estado_acepta' => $row['estado_acepta'],
            'estado_sii' => $row['estado_sii'],
            'estado_intercambio' => $row['estado_intercambio'],
            'informacion_intercambio' => $row['informacion_intercambio'],
            'uri' => $row['uri'],
            'referencias' => $row['referencias'],
            'fecha_nar' => isset($row['fecha_nar']) ? Carbon::instance(Date::excelToDateTimeObject($row['fecha_nar'])) : null,
            'estado_nar' => $row['estado_nar'],
            'uri_nar' => $row['uri_nar'],
            'mensaje_nar' => $row['mensaje_nar'],
            'uri_arm' => $row['uri_arm'],
            'fecha_arm' => $row['fecha_arm'],
            'fmapago' => $row['fmapago'],
            'controller' => $row['controller'],
            'fecha_vencimiento' => isset($row['fecha_vencimiento']) ? Carbon::instance(Date::excelToDateTimeObject($row['fecha_vencimiento'])) : null,
            'estado_cesion' => $row['estado_cesion'],
            'url_correo_cesion' => $row['url_correo_cesion'],
            'fecha_recepcion_sii' => $row['fecha_recepcion_sii'],
            'estado_reclamo' => $row['estado_reclamo'],
            'fecha_reclamo' => $row['fecha_reclamo'],
            'mensaje_reclamo' => $row['mensaje_reclamo'],
            'estado_devengo' => $row['estado_devengo'],
            'codigo_devengo' => $row['codigo_devengo'],
            'fecha_ingreso_oc' => $row['fecha_ingreso_oc'],
            'folio_rc' => $row['folio_rc'],
            'fecha_ingreso_rc' => $row['fecha_ingreso_rc'],
            'ticket_devengo' => $row['ticket_devengo'],
            'folio_sigfe' => $row['folio_sigfe'],
            'tarea_actual' => $row['tarea_actual'],
            'area_transaccional' => $row['area_transaccional'],
            'fecha_ingreso' => $row['fecha_ingreso'],
            'fecha_aceptacion' => $row['fecha_aceptacion'],
            'fecha' => $row['fecha'],
        ];

        if( trim(mb_strtoupper($row['folio_oc'])) != '' AND !is_null($row['folio_oc']) ) 
        {
            $purchase_order = null;
            $folio_oc = trim(mb_strtoupper($row['folio_oc']));
            $array_variable['folio_oc'] = $folio_oc;
            $array_variable['establishment_id'] = Prefix::getEstablishmentIdFromPoCode($folio_oc);
            $purchase_order = PurchaseOrder::where('code',$folio_oc)->first();

            if(Prefix::getIsCenabastFromPoCode($folio_oc))
            {
                
                if($purchase_order) {
                    $purchase_order->cenabast = 1;
                    $purchase_order->save();

                }
            }

            if($purchase_order and $purchase_order?->requestForm)

            {
                
                $requestForm = $purchase_order->requestForm;
                if($requestForm->contract_manager_id)
                {
                    $array_variable['contract_manager_id'] = $requestForm->contract_manager_id;
                    $array_variable['confirmation_sender_id'] = auth()->user()->id;
                    $array_variable['confirmation_send_at'] = now();

                    $temporaryDte = new Dte($array_variable);

                    $this->sendDteNotification($temporaryDte, $requestForm);

                    //app('debugbar')->info($requestForm->contract_manager_id);
                }
            }
        }
                // Crear o actualizar el DTE
                $dte = Dte::updateOrCreate($array_clave, $array_variable);

                // Verificar si hay una referencia con tipo "52"
                if ($row['tipo_documento'] == 'factura_electronica') {
                    $referencias = json_decode($row['referencias'], true);
                    if (is_array($referencias)) {
                        foreach ($referencias as $referencia) {
                            if (isset($referencia['Tipo']) && $referencia['Tipo'] == '52') {
                                $folio_gd = $referencia['Folio'];
                                $this->linkGuiaDespachoToFactura($dte, $folio_gd);
                                break;
                            }
                        }
                    }
                }

                return $dte;
            }
        

        /**
     * Envía la notificación DteConfirmation
     *
     * @param Dte $dte
     * @return void
     */
    private function sendDteNotification(Dte $dte, $requestForm)
    {
        $contract_manager = User::find($requestForm->contract_manager_id);
        if($contract_manager)
        {   
            $contract_manager->notify(new DteConfirmation($dte));
        }
        
    }


    private function linkGuiaDespachoToFactura(Dte $factura, $folio_gd)
    {
        $guia_despacho = Dte::where('folio', $folio_gd)->where('emisor', $factura->emisor)->first();
        if ($guia_despacho) {
            $guia_despacho->invoices()->syncWithoutDetaching($factura->id);
        }
        
        //se recepciono con factura
        if($factura and $factura->receptions->first()  and $factura->receptions->first()->guia_id == null)
        {
            $factura->receptions->first()->guia_id = $guia_despacho->id;
            $factura->receptions->first()->save();


        }
        //se recepciono con la guia
        if($guia_despacho and $guia_despacho->receptions->first() and $guia_despacho->receptions->first()->dte_id == null)
        {
            
            $guia_despacho->receptions->first()->dte_id = $factura->id;
            $guia_despacho->receptions->first()->save();

        }

    }

}