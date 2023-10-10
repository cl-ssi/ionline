<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Notifications\Documents\NewApproval;
use App\Models\Finance\Dte; // Sólo para el ejemplo, no tiene uso
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Approval extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Ejemplo de uso
     * Esta funcion no se usa, es sólo para ejemplo del código
     * Se puede correr en tinker:
     * App\Models\Documents\Approval::ejemplo_de_uso();
     */
    public static function ejemplo_de_uso() {
        /**
         * Hay dos formas de crear un Approval
         * - Approval::create(['module' => 'xxx',...])
         * - A través de una relación:
         *      $approval = $requestForms->approvals()->create(['module' => 'xxx', ...])
         **/

        /** o crear y asociar a un modelo a través de su relación, como el siguente ejemplo */
        $dte = Dte::first();

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
            "document_route_params" => json_encode([
                "po_code" => "1272565-444-AG23"
            ]),

            /** Quien firma: Utilizar uno de los dos */
            /* (Opcional) De preferncia enviar la aprobación a la OU */
            "approver_ou_id" => 20,




            /* (Opcional) Se puede enviar directo a una persona (es el user_id), pero hay que evitarlo */
            //"approver_id" => 15287582,

            /* (Opcional) Metodo que se ejecutará al realizar la aprobación o rechazo */
            //"callback_controller_method" => "App\Http\Controllers\Finance\DteController@process",

            /* (Opcional) Parámetros que se le pasarán al método callback */
            // "callback_controller_params" => json_encode([
            //         //'approval_id' => xxx  <= este parámetro se agregará automáticamente al comienzo
            //         'param1' => 15,
            //         'param2' => 'abc'
            //     ]),

            /**
             * Ejemplo de método del controlador que procesa el callback
             * Este bloque de código va en el DteController, según el ejemplo de arriba.
             **/
            // public function process($approval_id, $param1, $param2) {
            //     logger()->info('Prueba de callback modulo aprobaciones: id ' . $approval_id. ' param1: '. $param1);
            // }


            /**
             * (Opcional) True(default) or False, setear en false si queremos desactivar la aprobación
             * Esto es necesario principalmente cuando es en cadena, se deja activa sólo la primera
             * y todas las demás quedan en false, más abajo hay un ejemplo de aprobaciones en cadena
             **/
            //"active" => true,

            /**
             * (Opcional) Se utiliza el previous_approval_id (id de el Approval anterior)
             * para cuando es en cadena de responsabilidad. Se debe utilizar en conjunto con
             * la propiedad active.
             * Dejar active == true sólo al primero y todos los demás en false.
             *
             * Ej de cadena, id: 17 luego se ejecuta el id 18, luego el id 19
             *
             * id  |  previous_approval_id  | active
             * =====================================
             * 17  |       null             |  true
             * 18  |        17              |  false
             * 19  |        18              |  false
             */
            //"previous_approval_id" => 17,


            /**
             * Relación polimórfica
             * Agregar esta relación al modelo que quieres que tenga approvals
             * Ejemplo: Modelo RequestForm, y luego podrías llamrla así:
             * $requestForm->approvals (tendría una colección de approvals)
             **/


             /** Para one to many **/

             /**
             * Get all of the approvations of a model.
             */
            // public function approvals(): MorphMany
            // {
            //     return $this->morphMany(Approval::class, 'approvable');
            // }

            /** Para One to One */

            /**
             * Get the approval model.
             */
            // public function approval(): MorphOne
            // {
            //     return $this->morphOne(Approval::class, 'approvable');
            // }

            /**
             * Ejemplo para crear y asociar al mismo tiempo:
             *
             * $requestForm->approvals()->create([
             *      "module" => "Formulario de Req..",
             *       ...
             * ]);
             **/


            /**
             * Opciones para utilizar firma electrónica avanzada en vez de aprobación simple
             * ==============================================================================
             */
            /* (Opcional) True or False(default), Si requiere firma electrónica en vez de aprobación simple */
            //"digital_signature" => true,

            /* (Opcional) Posición ("columna") de la firma en el documento: center, left, right */
            //"position" => "center",

            /* (Opcional) Margen inferior: Distancia desde el final de la hoja hacia arriba usualmente 80 */
            //"startY" => 80,

            /* (Opcional) ruta con nombre del archivo que se guardará en el storage, ej: ionline/documents/modulo/id (sin extensión)*/
            //"filename" => "ionline/documents/approvals/archivo",
        ]);
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
        'approver_id', //  user_id, asignar en caso de aprobación o rechazo
        'status', // True or False, asignar en caso de aprobación o rechazo
        'approver_at', // Datetime, asignar en caso de aprobación o rechazo
        'callback_controller_method',
        'callback_controller_params',
        'reject_observation',
        'active',
        'previous_approval_id',
        'approvable_id',
        'approvable_type',
        'digital_signature',
        'position',
        'startY',
        'filename',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'approver_at' => 'datetime',
    ];

    public function organizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class,'approver_ou_id')->withTrashed();
    }

    public function approver()
    {
        return $this->belongsTo(User::class,'approver_id')->withTrashed();
    }

    /**
     * Get the next approval associated with this approval.
     */
    public function nextApproval(): HasOne
    {
        return $this->hasOne(Approval::class, 'previous_approval_id');
    }

    /**
     * Get the previous approval.
     */
    public function previousApproval(): BelongsTo
    {
        return $this->belongsTo(Approval::class, 'previous_approval_id');
    }

    /**
     * Get the polymorphic  parent approvable model:
     * - ModificationRequest
     * - NoAttendanceRecord
     */
    public function approvable(): MorphTo
    {
        return $this->morphTo();
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

    /**
    * Get Color With status
    */
    public function getStatusInWordsAttribute()
    {
        switch($this->status) {
            case '0': return 'Rechazado'; break;
            case '1': return 'Aprobado'; break;
            default: return 'Pendiente'; break;
        }
    }

    /**
    * Get Status Icon
    */
    public function getIconAttribute()
    {
        switch($this->status) {
            case '0': return 'fa-thumbs-down'; break;
            case '1': return 'fa-thumbs-up'; break;
            default: return 'fa-clock'; break;
        }
    }

    public function getFilenameLinkAttribute()
    {
        $filename = $this->filename.'.pdf';

        $link = null;

        if(Storage::disk('gcs')->exists($filename))
        {
            $link = Storage::disk('gcs')->url($filename);
        }

        return $link;
    }

    public function getFilenameBase64Attribute()
    {
        $documentBase64Pdf = base64_encode(file_get_contents($this->filename_link));

        return $documentBase64Pdf;
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($approval) {
            /** Enviar notificación al jefe de la unidad  */
            if($approval->approver_ou_id) {
                $approval->organizationalUnit->currentManager?->user?->notify(new NewApproval($approval));
            }
            /** Si tiene un aprobador en particular envia la notificación al usuario específico */
            if($approval->approver_id) {
                $approval->approver->notify(new NewApproval($approval));
            }

            /** Agregar el approval_id al comienzo de los parámetros del callback */
            /** Solo si tiene un callback controller method */
            if($approval->callback_controller_method) {
                $params = json_decode($approval->callback_controller_params,true);
                $approval->callback_controller_params = json_encode(array_merge(array('approval_id' => $approval->id), $params));
                $approval->save();
            }
        });

        static::updated(function ($approval) {
            /** Preguntar si el estado cambio de null a true (los falsos no continuan la cadena) */
            if ( $approval->status === true ) {
                /* Preguntar si tiene un NextApproval (es en cadena) */
                if ($approval->nextApproval) {
                    /** Activar el NextApproval */
                    $approval->nextApproval->update(['active' => true]);

                    /** Notificar al jefe de unidad o persona */
                    /** Enviar notificación al jefe de la unidad  */
                    if($approval->nextApproval->approver_ou_id) {
                        $approval->nextApproval->organizationalUnit->currentManager?->user?->notify(new NewApproval($approval->nextApproval));
                    }
                    /** Si tiene un aprobador en particular envia la notificación al usuario específico */
                    if($approval->nextApproval->approver_id) {
                        $approval->nextApproval->aprover->notify(new NewApproval($approval->nextApproval));
                    }
                }
            }
        });
    }
}
