<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ReplacementStaff extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'run', 'dv', 'birthday', 'name', 'fathers_family',
        'mothers_family', 'gender', 'email', 'telephone',
        'telephone2', 'commune', 'address', 'observations',
        'file', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function getFullNameAttribute()
    {
        return strtoupper("{$this->name} {$this->fathers_family} {$this->mothers_family}");
    }

    public function getIdentifierAttribute()
    {
        return strtoupper("{$this->run}-{$this->dv}");
    }

    public function profiles() {
        return $this->hasMany('\App\Models\ReplacementStaff\Profile');
    }

    // public function experiences() {
    //     return $this->hasMany('\App\Models\ReplacementStaff\Experience');
    // }

    public function trainings() {
        return $this->hasMany('\App\Models\ReplacementStaff\Training');
    }

    // public function languages() {
    //     return $this->hasMany('\App\Models\ReplacementStaff\Language');
    // }

    public function getStatusValueAttribute(){
        switch ($this->status) {
            case 'available':
              return 'Disponible';
              break;
            default:
              return '';
              break;
        }
    }

    protected $table = 'rst_replacement_staff';
}
