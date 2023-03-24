<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Models\ServiceRequests\Denomination1121;
use App\Models\ServiceRequests\DenominationFormula;
use app\User;
use Carbon\Carbon;
use DatePeriod;
use DateInterval;

class Fulfillment extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  use HasFactory;
  use SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id', 'service_request_id', 'year', 'month', 'type', 'start_date', 'end_date', 'observation',
    'responsable_approbation', 'responsable_approbation_date', 'responsable_approver_id',
    'rrhh_approbation', 'rrhh_approbation_date', 'rrhh_approver_id', 'payment_ready', 'has_invoice_file', 'has_invoice_file_at', 'has_invoice_file_user_id',
    'finances_approbation', 'finances_approbation_date', 'finances_approver_id', 'invoice_path', 'user_id',
    'bill_number', 'total_hours_to_pay', 'total_to_pay', 'total_to_pay_add_date', 'total_hours_paid', 'total_paid', 'payment_date', 'contable_month',
    'payment_rejection_detail', 'illness_leave', 'leave_of_absence', 'assistance','backup_assistance'

  ];


  public function Denominations1121()
  {
      return $this->belongsToMany(Denomination1121::class, 'doc_1121_fulfillments', 'doc_1121_id', 'doc_fulfillments_id', )->withTimestamps();
  }

  public function DenominationsFormula()
  {
      return $this->belongsToMany(DenominationFormula::class, 'doc_formula_fulfillments', 'doc_formula_id', 'doc_fulfillments_id', )->withTimestamps();
  }

  public function MonthOfPayment()
  {
    if ($this->contable_month) {
      if ($this->contable_month == 1) {
        return "Enero";
      } elseif ($this->contable_month == 2) {
        return "Febrero";
      } elseif ($this->contable_month == 3) {
        return "Marzo";
      } elseif ($this->contable_month == 4) {
        return "Abril";
      } elseif ($this->contable_month == 5) {
        return "Mayo";
      } elseif ($this->contable_month == 6) {
        return "Junio";
      } elseif ($this->contable_month == 7) {
        return "Julio";
      } elseif ($this->contable_month == 8) {
        return "Agosto";
      } elseif ($this->contable_month == 9) {
        return "Septiembre";
      } elseif ($this->contable_month == 10) {
        return "Octubre";
      } elseif ($this->contable_month == 11) {
        return "Noviembre";
      } elseif ($this->contable_month == 12) {
        return "Diciembre";
      }
    }
  }

  public function shiftControls()
  {
    return $this->hasMany('\App\Models\ServiceRequests\ShiftControl');
  }

  public function FulfillmentItems()
  {
    return $this->hasMany('\App\Models\ServiceRequests\FulfillmentItem');
  }

  public function ServiceRequest()
  {
    return $this->belongsTo('\App\Models\ServiceRequests\ServiceRequest');
  }

  public function responsableUser()
  {
    return $this->belongsTo('App\User', 'responsable_approver_id')->withTrashed();
  }

  public function rrhhUser()
  {
    return $this->belongsTo('App\User', 'rrhh_approver_id')->withTrashed();
  }

  public function financesUser()
  {
    return $this->belongsTo('App\User', 'finances_approver_id')->withTrashed();
  }

  public function voiceUploader()
  {
    return $this->belongsTo('App\User', 'has_invoice_file_user_id')->withTrashed();
  }

  public function signedCertificate()
  {
    return $this->belongsTo('App\Models\Documents\SignaturesFile', 'signatures_file_id');
  }

  public function attachments() {
    return $this->hasMany('App\Models\ServiceRequests\Attachment');
}

  public function scopeSearch($query, Request $request)
  {

    /*
      if ($request->input('rut') != "") {
      $query->whereHas('servicerequest', function ($q) use ($request) {

        $q->whereHas('employee', function ($q) use($request) {
          $q->where('id', $request->input('rut'))
          ->orWhere('fathers_family', 'LIKE', '%'.$request->input('rut').'%')
          ->orWhere('name', 'LIKE', '%'.$request->input('rut').'%')
          ->orWhere('mothers_family', 'LIKE', '%'.$request->input('rut').'%');
        });
      });
    }*/

    // $query->whereHas("responsabilityCenter", function($subQuery) use ($establishment_id){
    //   $subQuery->where('establishment_id', Auth::user()->organizationalUnit->establishment_id);
    // });

    if ($request->input('establishment') != "") {
      $query->whereHas('servicerequest', function ($q) use ($request) {
        $q->where('establishment_id', $request->input('establishment'));
      });
    }

    if ($request->input('sr_id') != "") {
      $query->whereHas('servicerequest', function ($q) use ($request) {
        $q->Where('id', $request->input('sr_id'));
      });
    }

    if ($request->input('rut') != "") {
      $query->whereHas('servicerequest', function ($q) use ($request) {
        $q->whereHas('employee', function ($q) use ($request) {
          $users = User::getUsersBySearch($request->input('rut'));
          $q->whereIn('id', $users->get('id'));
        });
      });
    }

    if ($request->input('year') != "") {
      $query->where('year', $request->input('year'));
    }

    if ($request->input('month') != "") {
      $query->where('month', $request->input('month'));
    }


    if ($request->input('program_contract_type') != "") {
      $query->whereHas('servicerequest', function ($q) use ($request) {
        $q->Where('program_contract_type', $request->input('program_contract_type'));
      });
    }


    if ($request->input('type') != "") {
      $query->whereHas('servicerequest', function ($q) use ($request) {
        $q->Where('type', $request->input('type'));
      });
    }

    if ($request->input('programm_name') != "") {
      $query->whereHas('servicerequest', function ($q) use ($request) {
        $q->Where('programm_name', $request->input('programm_name'));
      });
    }

    if ($request->input('resolution') != "") {
      if ($request->input('resolution') == 'Yes') {
        $query->whereHas('serviceRequest', function ($q) use ($request) {
          $q->where('has_resolution_file', 1);
        });
        if ($request->input('resolution') == 'No') {
          $query->whereHas('serviceRequest', function ($q) use ($request) {
            $q->whereNull('has_resolution_file');
          });
        }
      }
    }


    if ($request->input('payment_date') != "") {
      if ($request->input('payment_date') == 'P') {
        $query->whereNotNull('payment_date');
      }
      if ($request->input('payment_date') == 'SP') {
        $query->whereNull('payment_date');
      }
    }

    if ($request->input('certificate') != "") {
      if ($request->input('certificate') == 'Yes') {
        $query->whereNotNull('signatures_file_id');
      }
      if ($request->input('certificate') == 'No') {
        $query->whereNull('signatures_file_id');
      }
    }

    if ($request->input('ok_responsable') != "") {
      if ($request->input('ok_responsable') == 'Yes') {
        $query->whereNotNull('responsable_approbation');
      }
      if ($request->input('ok_responsable') == 'No') {
        $query->whereNull('responsable_approbation');
      }
    }

    if ($request->input('ok_rrhh') != "") {
      if ($request->input('ok_rrhh') == 'Yes') {
        $query->whereNotNull('rrhh_approbation');
      }
      if ($request->input('ok_rrhh') == 'No') {
        $query->whereNull('rrhh_approbation');
      }
    }


    if ($request->input('ok_finances') != "") {
      if ($request->input('ok_finances') == 'Yes') {
        $query->whereNotNull('finances_approbation');
      }
      if ($request->input('ok_finances') == 'No') {
        $query->whereNull('finances_approbation');
      }
    }

    if ($request->input('invoice') != "") {
      if ($request->input('invoice') == 'Yes') {
        $query->whereNotNull('has_invoice_file');
      }
      if ($request->input('invoice') == 'No') {
        $query->whereNull('has_invoice_file');
      }
    }


    if ($request->input('working_day_type') != "") {
      $query->whereHas('servicerequest', function ($q) use ($request) {
        $q->Where('working_day_type', $request->input('working_day_type'));
      });
    }

    // if ($request->has('certificate')) {
    //   $query->whereNotNull('signatures_file_id');
    // } else {
    //   $query->whereNull('signatures_file_id');
    // }

    // if ($request->has('invoice')) {
    //   $query->whereNotNull('has_invoice_file');
    // } else {
    //   $query->whereNull('has_invoice_file');
    // }

    // if ($request->has('payed')) {
    //   $query->whereNotNull('payment_date');
    // } else {
    //   $query->whereNull('payment_date');
    // }

    // if ($request->has('ok_responsable')) {
    //   $query->whereNotNull('responsable_approbation');
    // } else {
    //   $query->whereNull('responsable_approbation');
    // }



    // if ($request->has('ok_finanzas')) {
    //   $query->whereNotNull('finances_approbation');
    // } else {
    //   $query->whereNull('finances_approbation');
    // }

    return $query;
  }

  public function quit_status()
  {
    foreach ($this->FulfillmentItems as $key => $fulfillmentItem) {
      if ($fulfillmentItem->type == "Renuncia voluntaria" ||
          $fulfillmentItem->type == "Abandono de funciones" ||
          $fulfillmentItem->type == "Término de contrato anticipado") {
        return "Sí";
      }
    }
    return "No";
  }


    //A continuación, funciones que se utilizan para el cálculo del total a cobrar de cada período.
    public function aguinaldopatrias($serviceRequest)
    {
        $startDate = $serviceRequest->start_date;
        $endDate = $serviceRequest->end_date;
        $septiembre = \Carbon\Carbon::createFromFormat('Y-m-d', '2021-09-1');
        $check = $septiembre->between($startDate, $endDate);

        if ($check) {

            switch ($serviceRequest->programm_name) {
                case 'PESPI':
                case 'SENDA':
                case 'OTROS PROGRAMAS SSI':
                case 'CHILE CRECE CONTIGO':

                    if ($serviceRequest->net_amount <= 794149) {
                        return (" en la cuota de Septiembre percibirá un aguinaldo de $76.528");
                    } else {

                        switch ($serviceRequest->estate) {
                            case 'Profesional':
                                // dd('entre aca csm');
                                return (" en la cuota de Septiembre percibirá un aguinaldo de $53.124");

                                break;
                            default:
                                /* TODO: No sé que hacer acá */
                                return (" en la cuota de Septiembre percibirá un aguinaldo de $76.528");
                                break;
                        }
                    }
            }
        }
    }

    // funcion que calcula monto considerando inasistencias del período indicado
    public function monto_con_inasistencias($mes_completo, $mes, $monto)
    {
      $fulfillment = $this->serviceRequest->fulfillments->where('month',$mes)->first();

      if ($fulfillment) {
        $total_dias_trabajados = 0;
        $mes_completo = true;

        /* si tiene una "Renuncia voluntaria", el termino del contrato es ahí */
        if ($renuncia = $fulfillment->fulfillmentItems->where('type', 'Renuncia voluntaria')->first()) {
            $fulfillment->end_date = $renuncia->end_date;
        }

        /* si inicio de contrato coincide con inicio de mes y término de contrato coincide con fin de mes */
        if ($fulfillment->start_date and $fulfillment->end_date) {
            if (
                $fulfillment->start_date->toDateString() == $fulfillment->start_date->startOfMonth()->toDateString()
                and $fulfillment->end_date->toDateString() == $fulfillment->end_date->endOfMonth()->toDateString()
            ) {
                $total_dias_trabajados = 30;
                $mes_completo = true;
            }

            /* De lo contrario es la diferencia entre el primer y último día */ else {
                $total_dias_trabajados = $fulfillment->start_date->diff($fulfillment->end_date)->days + 1;
                $mes_completo = false;
            }
        }

        /* Restar las ausencias */
        $dias_descuento = 0;
        $dias_trabajado_antes_retiro = 0;
        $hrs_descuento = 0;
        $mins_descuento = 0;

        foreach ($fulfillment->fulfillmentItems as $item) {
            switch ($item->type) {
                case 'Inasistencia Injustificada':
                    $mes_completo = false;
                    $dias_descuento += $item->end_date->diff($item->start_date)->days + 1;
                    break;
                case 'Licencia no covid':
                    $mes_completo = false;
                    $dias_descuento += $item->end_date->diff($item->start_date)->days + 1;
                    break;
                case 'Abandono de funciones':
                    $mes_completo = false;
                    $dias_descuento += $item->end_date->diff($item->start_date)->days + 1;
                    $dias_trabajado_antes_retiro = ((int)$item->end_date->format("d"))-(int)$fulfillment->start_date->format("d") ;
                    break;
                case 'Renuncia voluntaria':
                    $mes_completo = false;
                    // evita ocurrir error si no existe end_date
                    if ($item->end_date == null) {
                      $dias_trabajado_antes_retiro = 0;
                      break;
                    }
                    $dias_trabajado_antes_retiro = (int)$item->end_date->format("d") - 1;
                    $dias_descuento += 1;
                    break;
                case 'Término de contrato anticipado':
                        $mes_completo = false;
                        // evita ocurrir error si no existe end_date
                        if ($item->end_date == null) {
                          $dias_trabajado_antes_retiro = 0;
                          break;
                        }
                        $dias_trabajado_antes_retiro = (int)$item->end_date->format("d") - 1;
                        $dias_descuento += 1;
                        break;
                case 'Atraso':
                    $mes_completo = false;
                    $mins_descuento += $item->end_date->diffInMinutes($item->start_date);
                    break;
            }
        }

        $total_dias_trabajados -= $dias_descuento;

        // se verifica si hay retiro para calcular la cantidad de dias trabajados
        if ($mes_completo) {
            $total = $monto - ($dias_descuento * ($monto / 30));
        } else {
            if ($dias_trabajado_antes_retiro == 0) {

            }
            if ($dias_trabajado_antes_retiro != 0) {

                $total_dias_trabajados = $dias_trabajado_antes_retiro;
            }
            $total = $total_dias_trabajados * ($monto / 30);
        }

        if ($hrs_descuento != 0) {
          $valor_hora = ($monto / 30 / 8.8);
          $total_dcto_horas = $hrs_descuento * $valor_hora;
          $total = $total - $total_dcto_horas;
        }

        if ($mins_descuento >= 60) {
            $valor_hora = ($monto / 30 / 8.8);
            $hrs_descuento = floor($mins_descuento/60);
            $total_dcto_horas = $hrs_descuento * $valor_hora;
            $total = $total - $total_dcto_horas;
          }

        return $total;
      }

    }

    public function items_verification($month)
    {
      foreach ($this->serviceRequest->fulfillments->where('month',$month) as $key => $fulfillment) {
          foreach ($fulfillment->fulfillmentItems as $item) {
              switch ($item->type) {
                  case 'Inasistencia Injustificada':
                  case 'Licencia no covid':
                  case 'Abandono de funciones':
                  case 'Atraso':
                    if ($item->end_date == null) {
                      return false;
                    }
                    if ($item->start_date == null) {
                      return false;
                    }
                  case 'Renuncia voluntaria':
                  case 'Término de contrato anticipado':
                    if ($item->end_date == null) {
                      return false;
                    }
              }
          }
      }
      return true;
    }

    public function getValueMonthlyQuoteValue(){
        $serviceRequest = $this->ServiceRequest;

        $first_month = $serviceRequest->start_date->month;
        $last_month  = $serviceRequest->end_date->month;
        /* TODO: Que pasa si un contrato pasa al siguiente año? */
        $year = $serviceRequest->start_date->year;


        $valores_mensualizados = array();
        if ($serviceRequest->start_date->format('Y-m-d') == $serviceRequest->start_date->firstOfMonth()->format('Y-m-d') and $serviceRequest->end_date->format('Y-m-d') == $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {

            $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
            $valor_mensual = $serviceRequest->net_amount;
            $interval = DateInterval::createFromDateString('1 month');
            $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date);
            $periods = iterator_to_array($periods);
            foreach ($periods as $key => $period) {
                if ($key === array_key_first($periods)) {
                    if ($this->items_verification($period->month)) {
                      $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                    }else{
                      $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                    }
                } else if ($key === array_key_last($periods)) {
                    $this->items_verification($period->month);
                    if ($this->items_verification($period->month)) {
                      $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                    }else{
                      $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                    }
                } else {
                    if ($this->items_verification($period->month)) {
                      $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                    }else{
                      $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                    }
                }
            }
        } else
        //son cuotas valores diferentes
        {
            // la persona trabaja menos de 1 mes
            $diff_in_months = $serviceRequest->end_date->diffInMonths($serviceRequest->start_date);
            if ($diff_in_months < 1) {
                if ($this->items_verification($serviceRequest->start_date->month)) {
                  $valores_mensualizados[$serviceRequest->start_date->month] = number_format($this->monto_con_inasistencias(false, $serviceRequest->start_date->month, $serviceRequest->net_amount));
                }else{
                  $valores_mensualizados[$serviceRequest->start_date->month] = "Revise los datos ingresados en el cuadro de responsable.";
                }

            } else {

                if ($serviceRequest->start_date->format('Y-m-d') != $serviceRequest->start_date->firstOfMonth()->format('Y-m-d') and $serviceRequest->end_date->format('Y-m-d') != $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {
                    $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 2;
                    $valor_mensual = $serviceRequest->net_amount;
                    $interval = DateInterval::createFromDateString('1 month');
                    $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date->addMonth());
                    $periods = iterator_to_array($periods);
                    $dias_trabajados1 = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                    // se modifica el cálculo según correo
                    $valor_diferente1 = round($dias_trabajados1 * ($valor_mensual / 30));
                    $dias_trabajados2 = $serviceRequest->end_date->firstOfMonth()->diff($serviceRequest->end_date)->days + 1;
                    //dd($dias_trabajados2);
                    $valor_diferente2 = round($dias_trabajados2 * ($valor_mensual / 30));

                    foreach ($periods as $key => $period) {
                        if ($key === array_key_first($periods)) {
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente1));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else if ($key === array_key_last($periods)) {
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente2));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else {
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        }
                    }
                } elseif ($serviceRequest->start_date->format('Y-m-d') != $serviceRequest->start_date->firstOfMonth()->format('Y-m-d')) {

                    //La Persona no parte a trabajar en un mes cerrado
                    $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
                    $valor_mensual = $serviceRequest->net_amount;
                    $interval = DateInterval::createFromDateString('1 month');
                    $periods   = new DatePeriod($serviceRequest->start_date->firstOfMonth(), $interval, $serviceRequest->end_date->endOfMonth());
                    $periods = iterator_to_array($periods);
                    //erg: comenté la linea siguiente porque desconozco el +1 que se hace al final, estaba afectando cálculo de nataly 16/02/2022
                    $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                    $valor_diferente = round($dias_trabajados * ($valor_mensual / 30));

                    foreach ($periods as $key => $period) {
                        if ($key === array_key_first($periods)) {
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else if ($key === array_key_last($periods)) {
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else {
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        }
                    }
                }
                //la persona termina de trabajar en un día que no es fin de mes
                elseif ($serviceRequest->end_date->format('Y-m-d') != $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {
                    $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
                    $valor_mensual = $serviceRequest->net_amount;
                    $interval = DateInterval::createFromDateString('1 month');
                    $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date);
                    $periods = iterator_to_array($periods);
                    $dias_trabajados = (int)$serviceRequest->end_date->format('d');
                    $valor_diferente = round($dias_trabajados * ($valor_mensual / 30));

                    foreach ($periods as $key => $period) {
                        if ($key === array_key_first($periods)) {
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else if ($key === array_key_last($periods)) {
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else {
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        }
                    }
                }
            }
        }

        return $valores_mensualizados[$this->month];
    }


  protected $table = 'doc_fulfillments';

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['start_date', 'end_date', 'payment_date', 'total_to_pay_at', 'has_invoice_file_at'];
}
