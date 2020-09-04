<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = [
        'name','name_municipality','rut_municipality','adress_municipality','appellative_representative','decree_representative','name_representative','rut_representative',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function commune() {
            return $this->hasOne('\App\Commune');
    }
}
