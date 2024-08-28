<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use App\Notifications\Documents\NewApproval;
use App\Models\Finance\Dte; // Sólo para el ejemplo, no tiene uso
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Approval extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Funcion de ejemplo de creación de un approval, se puede correr en tinker:
     * App\Models\Documents\Approval::ejemplo_de_uso();
     */
    public static function ejemplo_de_uso() {
        /**
         * COMO IMPLEMENTAR APPROVALS A UN MÓDULO
         * ======================================
         * Requisitos:
         *  1. Una ruta que genere un documento que se mostrará al usuario para que lo apruebe
         *     puede ser una vista o un pdf, se le pueden pasar parámetros (no pueden ser objetos)
         *     ej ruta: 'rrhh.attendance.no-records.show' parametros: [ "no_attendance_record_id" => "2863" ]
         * 
         * 
         *  2. Relación polimórfica al modelo que tendrá uno o más approvals, puede ser MorphOne o MorphMany.
         *     y luego podrías llamrla así: $modelo->approval(s) (tendrá uno o varios approvals)
         */
                /**
                 * Get the approval model.
                 */
                // public function approval(): MorphOne
                // {
                //     return $this->morphOne(Approval::class, 'approvable');
                // }

                /**
                 * Get all of the approvations of a model.
                 */
                // public function approvals(): MorphMany
                // {
                //     return $this->morphMany(Approval::class, 'approvable');
                // }

        /* 
         *  3. (Opcional) Un metodo en un controller que se ejecutará después de aprobar o rechazar 
         *      Ejemplo: App\Http\Controllers\Rrhh\NoAttendanceRecordController@approvalCallback
         */

                // public function approvalCallback($approval_id, $param1) {
                //     $approval = Approval::find($approval_id);
                //     if($approval->status === true) {
                //         logger()->info('Aprobado: id ' . $approval->id. ' param1: '. $param1);
                //     }
                //     else {
                //         logger()->info('Rechazado: id ' . $approval->id. ' motivo '. $approval->approver_observation);
                //     }
                // }
           
         /*
         *  4. Crear la instancia del approval y guardarla, ejemplo:
         *      Opción A: $modelo->approval()->create([...])
         *      Opción B: Approval::create([...]) y después asociarlo a un modelo
         *      (Hay un ejemplo con todos los parametros del create más abajo)
         *
         *
         *  5. (Opcional) Puedes incorporar un botón de Aprobación en tu módulo con este livewire:
         *      @livewire('documents.approval-button', [
         *          'approval' => $approval, 
         *          'redirect_route' => null, // (opcional) Redireccionar a una ruta despues de aprobar/rechazar
         *          'button_text' => null, // (Opcional) Texto del boton
         *          'button_size' => null, // (Opcional) Tamaño del boton: btn-sm, btn-lg, etc.
         *      ])
         * 
         **/


        /** 
         * EJEMPLO DE CREACIÓN DE UN APPROVAL Y TODOS LOS PARÁMETROS */
        $approval = Approval::create([

            /* Nombre del Módulo que está enviando la solicitud de aprobación */
            "module" => "Asistencia",

            /* Ícono del módulo para que aparezca en la bandeja de aprobación */
            "module_icon" => "fas fa-clock",

            /* Asunto de la aprobación */
            "subject" => "Nuevo registro de asistencia",

            /* Escoger: entre document_route_name o document_pdf_path Nombre de la ruta que se mostrará al hacer click en el documento */
            "document_route_name" => "rrhh.attendance.no-records.show",

            /* (Opcional) Parametros que reciba esa ruta */
            "document_route_params" => json_encode([
                "no_attendance_record_id" => "2863"
            ]),

            /* (Opcional) Ruta al archivo pdf que se va a mostrar y firmar, al setear esta variable se ignoran lass dos de arriba*/
            "document_pdf_path" => "ionline/samples/dummy.pdf",

            /** Quien firma: Utilizar uno de los dos */
            /* (Opcional) De preferncia enviar la aprobación a la OU */
            "sent_to_ou_id" => 20,

            /* (Opcional) Se puede enviar directo a una persona (es el user_id), pero hay que evitarlo */
            //"sent_to_user_id" => 15287582,

            /* (Opcional) Metodo que se ejecutará al realizar la aprobación o rechazo */
            //"callback_controller_method" => "App\Http\Controllers\Rrhh\NoAttendanceRecordController@approvalCallback",

            /* (Opcional) Parámetros que se le pasarán al método callback */
            // "callback_controller_params" => json_encode([
            //         //'approval_id' => xxx  <= este parámetro se agregará automáticamente al comienzo
            //         'param1' => 15,
            //         'param2' => 'abc'
            //     ]),


            /* (Opcional) es posible capturar información al momento de aprobar/rechazar, ver ejemplos de inputs a continuación */ 
            /* Estas no podrán ser firmadas en masa, ya que se requiere capturar la información por cada approval */
            // "callback_feedback_inputs" = json_encode([
            //     [
            //         "type" => "text",
            //         "label" => "Monto Neto",
            //         "name" => "ammount",
            //         "value" => null, // Acá se almacenará el resultado, no es necesario enviar
            //     ],
            //     [
            //         "type" => "select",
            //         "label" => "Cuenta Contable",
            //         "name" => "account_id",
            //         "options" => [
            //             10 => "Cuenta Insumos",
            //             30 => "Cuenta Medicamentos",
            //         ],
            //         "value" => null, // Acá se almacenará el resultado, no es necesario enviar
            //     ],
            // ]);


            /**
             * Opciones para utilizar en cadena de responsabilidad
             * ==============================================================================
             *
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
             * Opciones para utilizar firma electrónica avanzada en vez de aprobación simple
             * ==============================================================================
             */
            /* (Opcional) True or False(default), Si requiere firma electrónica en vez de aprobación simple */
            //"digital_signature" => true,

            /* (Opcional) Posición ("columna") de la firma en el documento: center, left, right */
            //"position" => "center",

            /* (Opcional) Margen inferior: Distancia desde el final de la hoja hacia arriba usualmente 80 */
            //"start_y" => 80,

            /**
             * Ruta con nombre del archivo que se generará y guardará en el storage
             * - Si "digital_signature" => true, : Firma Digital (Obligatorio) 
             * - Si "digital_signature" => false,: Aprobación Simple (Opcional) 
             * ej: ionline/modulo/approvals/documento.pdf
             */ 
            //"filename" => "ionline/modulo/approvals/documento.pdf",

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
        'document_pdf_path',    // Opcional

        'sent_to_ou_id',        // Enviado a una autoridad de una OU
        'sent_to_user_id',      // Enviado a un usuario en particular

        'approver_ou_id',       // ou_id, asignar en caso de aprobación/rechazo
        'approver_id',          // user_id, asignar en caso de aprobación/rechazo
        'approver_observation', // varchar, observación de aprobación/rechazo
        'approver_at',          // Datetime, asignar en caso de aprobación/rechazo
        'status',               // True or False, asignar en caso de aprobación/rechazo
        
        'callback_controller_method',
        'callback_controller_params',
        'callback_feedback_inputs',

        'active',
        'previous_approval_id',
        'approvable_id',
        'approvable_type',
        'digital_signature',
        'endorse',
        'position',
        'start_y',
        'filename',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'approver_at' => 'datetime',
        'status' => 'boolean',
        'active' => 'boolean',
        'digital_signature' => 'boolean',
        'endorse' => 'boolean',
    ];

    public function sentToOu()
    {
        return $this->belongsTo(OrganizationalUnit::class,'sent_to_ou_id')->withTrashed();
    }

    public function sentToUser()
    {
        return $this->belongsTo(User::class,'sent_to_user_id')->withTrashed();
    }

    public function approverOu()
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
     * - Fulfillment
     */
    public function approvable(): MorphTo
    {
        return $this->morphTo();
    }

    // Definir la relación 'attachments'
    // public function attachments()
    // {
    //     // Verificar si el modelo 'approvable' tiene la relación 'attachments'
    //     if (method_exists($this->approvable, 'attachments')) {
    //         return $this->approvable->attachments();
    //     }

    //     // Si no existe la relación 'attachments', retornar null o una colección vacía
    //     return collect(); // Puedes cambiar esto a 'null' si prefieres
    // }

    /**
    * Get Color With status
    */
    public function getColorAttribute()
    {
        return match ($this->status) {
            false => 'danger',
            true => 'success',
            default => '',
        };
    }

    /**
    * Get Color With status
    */
    public function getStatusInWordsAttribute()
    {
        return match ($this->status) {
            false => 'Rechazado',
            true => 'Aprobado',
            default => 'Pendiente',
        };
    }

    /**
    * Get Status Icon
    */
    public function getIconAttribute()
    {
        return match ($this->status) {
            false => 'fa-thumbs-down',
            true => 'fa-thumbs-up',
            default => 'fa-clock',
        };
    }

    /**
    * Reset approval a su estado pendiente
    */
    public function resetStatus()
    {
        $this->approver_ou_id = null;
        $this->approver_id = null;
        $this->approver_observation = null;
        $this->approver_at = null;
        $this->status = null;

        if($this->filename) {
            if(Storage::disk('gcs')->exists($this->filename)) {
                Storage::disk('gcs')->delete($this->filename);
            }
        }

        $this->save();
    }


    public function getFilenameLinkAttribute()
    {
        $link = null;

        if(Storage::disk('gcs')->exists($this->filename))
        {
            $link = Storage::disk('gcs')->url($this->filename);
        }

        return $link;
    }

    public function getFilenameBase64Attribute()
    {
        $documentBase64Pdf = base64_encode(Storage::disk('gcs')->get($this->filename));

        return $documentBase64Pdf;
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($approval) {
            /** Enviar notificación al jefe de la unidad  */
            if($approval->sent_to_ou_id) {
                $approval->sentToOu->currentManager?->user?->notify(new NewApproval($approval));
            }

            /** Si tiene un aprobador en particular envia la notificación al usuario específico */
            if($approval->sent_to_user_id) {
                $approval->sentToUser->notify(new NewApproval($approval));
            }

            /** Agregar el approval_id al comienzo de los parámetros del callback */
            /** Solo si tiene un callback controller method */
            if($approval->callback_controller_method) {
                $params = json_decode($approval->callback_controller_params,true) ?? [];
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
                    if($approval->nextApproval->sent_to_ou_id) {
                        $approval->nextApproval->sentToOu->currentManager?->user?->notify(new NewApproval($approval->nextApproval));
                    }
                    /** Si tiene un aprobador en particular envia la notificación al usuario específico */
                    if($approval->nextApproval->sent_to_user_id) {
                        $approval->nextApproval->sentToUser->notify(new NewApproval($approval->nextApproval));
                    }
                }
            }
        });
    }
}
