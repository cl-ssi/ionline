<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = [
        'name','name_municipality','rut_municipality','adress_municipality','appellative_representative','decree_representative',
        'name_representative','rut_representative','name_representative_surrogate','rut_representative_surrogate', 
        'decree_representative_surrogate', 'email_municipality', 'appellative_representative_surrogate'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function commune() {
            return $this->belongsTo('\App\Models\Commune');
    }
}
