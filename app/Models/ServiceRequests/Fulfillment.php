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
    'rrhh_approbation', 'rrhh_approbation_date', 'rrhh_approver_id', 'payment_ready', 'has_invoice_file',
    'finances_approbation', 'finances_approbation_date', 'finances_approver_id', 'invoice_path', 'user_id',
    'bill_number', 'total_hours_to_pay', 'total_to_pay', 'total_hours_paid', 'total_paid', 'payment_date', 'contable_month',
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

  protected $table = 'doc_fulfillments';

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['start_date', 'end_date', 'payment_date'];
}
