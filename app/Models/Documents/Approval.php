<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use App\Rrhh\OrganizationalUnit;

class Approval extends Model
{
    use HasFactory;

    /**
     * Ejemplo de uso
     * Esta funcion no se usa, es sólo para ejemplo del código
     * Se puede correr en tinker:
     * App\Models\Documents\Approval::ejemplo_de_uso();
     */
    public static function ejemplo_de_uso() {
        $approval = Approval::create([
            /* Nombre del Módulo que está enviando la solicitud de aprobación */
            "module" => "Estado de Pago",

            /* Ícono del módulo para que aparezca en la bandeja de aprobación */
            "module_icon" => "fas fa-rocket",

            /* Asunto de la aprobación */
            "subject" => "Nueva orden de compra",

            /* Nombre de la ruta que se mostrará al hacer click en el documento */
            "document_route_name" => "finance.purchase-orders.showByCode",
            
            /* (Opcional) Parametros que reciba esa ruta */
            "document_route_params" => json_encode(["1272565-444-AG23"]),

            /** Quien firma: Utilizar uno de los dos */
            /* (Opcional) De preferncia enviar la aprobación a la OU */
            "approver_ou_id" => 20,

            /* (Opcional) Se puede enviar directo a una persona, pero hay que evitarlo */
            "approver_id" => 15287582, 

            /* (Opcional) Metodo que se ejecutará al realizar la aprobación o rechazo */
            "callback_controller_method" => "App\Http\Controllers\Finance\DteController@process",

            /* (Opcional) Parámetros que se le pasarán al método callback */
            "callback_controller_params" => json_encode([
                    //'approval_id' => xxx  <= este parámetro se agregará automáticamente al comienzo
                    'param1' => 15, 
                    'param2' => 'abc'
                ]), 
            
            /* (Opcional) True or False(default), se requiere firma electrónica en vez de aprobación simple */
            "digital_signature" => false,
        ]);

        /** Ejemplo de método del controlador que procesa el callback */
        // public function process($approval_id, $param1, $param2) {
        //     logger()->info('Prueba de callback modulo aprobaciones: id ' . $approval_id. ' param1: '. $param1);
        // }
    }

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'sign_approvals';


    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'module',
        'module_icon',
        'subject',
        'document_route_name',
        'document_route_params',
        'approver_ou_id',
        'approver_id',
        'approver_at',
        'callback_controller_method',
        'callback_controller_params',
        'digital_signature',
    ];

    public function organizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class,'approver_ou_id')->withTrashed();
    }

    public function aprover()
    {
        return $this->belongsTo(User::class,'approver_id')->withTrashed();
    }

    /**
    * Get Color With status
    */
    public function getColorAttribute()
    {
        switch($this->status) {
            case '0': return 'danger'; break;
            case '1': return 'success'; break;
            default: return ''; break;
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($approval) {
            /** Enviar notificación al jefe de la unidad  */
            if($approval->approver_ou_id) {
                $approval->organizationalUnit->currentManager?->user?->notify(new \App\Notifications\Documents\NewApproval($approval));
            }
            /** De lo contrario enviar al usuario específico */
            else if($approval->approver_id) {
                $approval->aprover->notify(new \App\Notifications\Documents\NewApproval($approval));
            }

            /** Agregar el approval_id al comienzo de los parámetros del callback */
            $params = json_decode($approval->callback_controller_params,true);
            $approval->callback_controller_params = json_encode(array_merge(array('approval_id' => $approval->id), $params));
            $approval->save();
        });
    }
}
