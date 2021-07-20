<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftDateOfClosing extends Model
{
    use HasFactory;
    protected $table = 'rrhh_date_of_closing_of_shifts';
    protected $fillable = ['user_id','commentary' ,'init_date','close_date' ,'created_at' ];

}
