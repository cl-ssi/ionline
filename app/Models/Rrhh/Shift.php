<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class Shift extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'user_id',
        'year',
        'month',
        'quantity',
        'observation'
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'well_ami_shifts';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function monthName()
    {
        if ($this->month) {
            if ($this->month == 1) {
                return "Enero";
            } elseif ($this->month == 2) {
                return "Febrero";
            } elseif ($this->month == 3) {
                return "Marzo";
            } elseif ($this->month == 4) {
                return "Abril";
            } elseif ($this->month == 5) {
                return "Mayo";
            } elseif ($this->month == 6) {
                return "Junio";
            } elseif ($this->month == 7) {
                return "Julio";
            } elseif ($this->month == 8) {
                return "Agosto";
            } elseif ($this->month == 9) {
                return "Septiembre";
            } elseif ($this->month == 10) {
                return "Octubre";
            } elseif ($this->month == 11) {
                return "Noviembre";
            } elseif ($this->month == 12) {
                return "Diciembre";
            }
        }
    }

}
