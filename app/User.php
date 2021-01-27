<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Suitability\Result;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
    * El id no es incremental ya que es el run sin digito verificador
    */
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'dv', 'name', 'fathers_family','mothers_family','gender', 'email',
        'password','birthday','position','active','external'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function organizationalUnit() {
        return $this->belongsTo('\App\Rrhh\OrganizationalUnit');
    }

    public function telephones() {
        return $this->belongsToMany('\App\Resources\Telephone', 'res_telephone_user')->withTimestamps();
    }

    public function computers() {
        return $this->belongsToMany('\App\Resources\Computer', 'res_computer_user')->withTimestamps();
    }

    public function printers() {
        return $this->belongsToMany('\App\Resources\Printer', 'res_printer_user')->withTimestamps();
    }

    public function mobile() {
        return $this->hasOne('\App\Resources\Mobile');
    }


    public function scopeSearch($query, $name) {
        if($name != "") {
            return $query->where('name', 'LIKE', '%'.$name.'%')
                         ->orWhere('fathers_family', 'LIKE', '%'.$name.'%')
                         ->orWhere('mothers_family', 'LIKE', '%'.$name.'%');
        }
    }

    public function runFormat() {
        return number_format($this->id, 0,'.','.') . '-' . $this->dv;
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->fathers_family} {$this->mothers_family}";
    }

    public function getFirstNameAttribute() {
        $names = explode(' ',trim($this->name));
        return "{$names[0]}";
    }

    public function getInitialsAttribute()
    {
        return "{$this->name[0]}{$this->fathers_family[0]}{$this->mothers_family[0]}";
    }

    public function documentEvents() {
        return $this->hasMany('\App\Documents\DocumentEvent');
    }

    public function documents() {
        return $this->hasMany('App\Documents\Document');
    }

    public function reqCategories() {
        return $this->hasMany('App\Requirements\Category');
    }

    public function requirementStatus() {
        return $this->hasMany('App\Requirements\RequirementStatus');
    }

    public function requirements() {
        return $this->hasMany('App\Requirements\Requirement');
    }

    public function requirementsEventsFrom() {
        return $this->hasMany('App\Requirements\Event','from_user_id');
    }

    public function requirementsEventsTo() {
        return $this->hasMany('App\Requirements\Event','to_user_id');
    }

    public function purchases() {
        return $this->hasMany('App\Pharmacies\Purchase');
    }

    public function dispatches() {
        return $this->hasMany('App\Pharmacies\Dipatch');
    }

    public function receivings() {
        return $this->hasMany('App\Pharmacies\Receiving');
    }

    public function establishments() {
        return $this->belongsToMany('\App\Pharmacies\Establishment', 'frm_establishments_users')
                    ->withTimestamps();
    }

    public function userResults()
    {
        return $this->hasMany(Result::class, 'user_id', 'id');
        //return $this->hasMany('App\Models\Result', 'user_id', 'id');
    }

    /**computers
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'birthday'];
}
