<?php

namespace App\Models\Parameters;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'message',
        'module_id',
        'module',
        'uri',
        'formatted',
        'context',
        'level',
        'level_name',
        'channel',
        'extra',
        'remote_addr',
        'user_agent',
        'record_datetime',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Clasifica el log en base a los módulos y sus condiciones.
     */
    public function classify(): void
    {
        // Recupera todos los módulos de Module
        $modules = Module::all();

        // Iterar sobre cada módulo
        foreach ($modules as $module) {
            // Acceder al campo 'conditions' ya como un array
            $conditions = $module->conditions;

            if (isset($conditions) && is_array($conditions)) {
                // Verificar si alguna condición coincide con la URI del log
                foreach ($conditions as $pattern) {
                    if (preg_match($pattern, $this->uri) || preg_match($pattern, $this->message) || preg_match($pattern, $this->formatted)) {
                        // Si coincide, asignar el módulo al log y salir del loop
                        $this->module()->associate($module);
                        $this->save();

                        return; // Deja de clasificar una vez que encuentra un módulo
                    }
                }
            }
        }
    }

    protected function color(): Attribute
    {
        return Attribute::make(
            get: fn (): string => match ($this->level_name) {
                'INFO',
                'NOTICE',
                'DEBUG'   => 'info',
                'WARNING' => 'warning',
                'ERROR'   => 'danger',
                default   => 'danger',
            },
        );
    }
}
