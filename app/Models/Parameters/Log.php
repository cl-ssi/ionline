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

    public function logModule(): BelongsTo
    {
        return $this->belongsTo(LogModule::class);
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

    /**
     * Clasifica el log en base a los módulos y sus condiciones.
     */
    public function classify(): void
    {
        // Recupera todos los módulos de LogModule
        $modules = LogModule::all();

        // Iterar sobre cada módulo
        foreach ($modules as $module) {
            // Acceder al campo 'uri_conditions' ya como un array
            $uri_conditions = $module->uri_conditions;

            if (isset($uri_conditions) && is_array($uri_conditions)) {
                // Verificar si alguna condición coincide con la URI del log
                foreach ($uri_conditions as $pattern) {
                    if (preg_match($pattern, $this->uri) || preg_match($pattern, $this->message) || preg_match($pattern, $this->formatted)) {
                        // Si coincide, asignar el módulo al log y salir del loop
                        $this->logModule()->associate($module);
                        $this->save();
                        return; // Deja de clasificar una vez que encuentra un módulo
                    }
                }
            }
        }
    }
}
