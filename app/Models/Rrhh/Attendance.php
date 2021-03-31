<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id', 'type', 'timestamp', 'clock_id'];

    protected $table = 'rrhh_attendances';

    protected $dates = ['timestamp'];
}
