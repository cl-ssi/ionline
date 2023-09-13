<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;


    /**
     * Ejemplo de uso
     */

    // App\Models\Documents\Approval::create([
    //     "module" => "Rayen",
    //     "module_icon" => "edit",
    //     "subject" => "Asunto",
    //     "document_route_name" => "finance.purchase-orders.showByCode",
    //     "document_route_params" => json_encode(["1272565-444-AG23"]),
    //     "approver_ou_id" => 20, // De preferncia enviar la aprobación a la unidad y no al usuario
    //     "approver_id" => 15287582, // Opcional (evitar enviar a una persona)
    //     "callback_controller_method" => "App\Http\Controllers\Finance\DteController@process",  // Metodo que se ejecutará al realizar la aprobación o rechazo
    //     "callback_controller_params" => json_encode([ 'approval' => 1, 'user_id' => 15287582]), // Parámetros que se le pasarán al método callback
    // ]);

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
