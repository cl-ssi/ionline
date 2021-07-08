<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequestOfDay extends Model
{
    use HasFactory;
    protected $table = 'rrhh_user_request_of_days';
    protected $fillable = [ 'status','commentary','shift_user_day_id','user_id','status_change_by'];
}
