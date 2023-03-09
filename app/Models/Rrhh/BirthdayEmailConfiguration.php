<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthdayEmailConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'subject', 'tittle', 'message', 'status'];

    protected $table = 'rrhh_birthday_email_configuration';

    protected $dates = ['timestamp'];
}
