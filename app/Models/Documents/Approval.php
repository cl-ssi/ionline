<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            "module" => "Rayen",

            /* Ícono del módulo para que aparezca en la bandeja de aprobación */
            "module_icon" => "fas fa-rocket",

            /* Asunto de la aprobación */
            "subject" => "Asunto",

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
            /* Siempre se añadirá al principio de este arreglo el parámetro: 'approval_id' => xxx  */
            "callback_controller_params" => json_encode([
                    'param1' => 15, 
                    'param2' => 'abc'
                ]), 
            
            /* (Opcional) True or False(default), se requiere firma electrónica en vez de aprobación simple */
            "digital_signature" => false,
        ]);

    }

    /**
    * The primary key associated with the table.
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
}
