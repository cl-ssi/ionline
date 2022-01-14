<?php

namespace App\RequestForms;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RequestFormEvent extends Model
{
    public $table = "arq_request_form_events";

    protected $fillable = [
        'comment','request_form_id'
    ];

    public function getCreationDateAttribute()
    {
      return Carbon::parse($this->created_at)->format('d-m-Y H:i:s');
    }

    public function getCreationDateFormatAttribute()
    {
      return Carbon::parse($this->created_at)->formatLocalized('%d de %B del %Y');
    }

    public function getStatusNameAttribute()
    {
      switch ($this->status) {
        case 'create':
          return "Creado";
          break;

        case 'new':
          return "Nuevo";
          break;

        case 'approved_petitioner':
            return "Aprobado por solicitante";
            break;

        case 'approved_chief':
            return "Aprobado por jefatura";
            break;

        case 'item_record':
            return "Aprobado por jefatura - Registro Item";
            break;

        case 'crp_record':
            return "Aprobado por jefatura - Registro CRP";
            break;

        case 'approved_finance':
            return "Aprobado por finanzas";
            break;



        case 'reject':
            return "Rechazado";
            break;

        case 'closed':
          return "Cerrado";
          break;

        default:
          return "Nulo";
          break;
      }
    }

    public function request_form() {
        return $this->belongsTo('App\RequestForms\RequestForm');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }
}
