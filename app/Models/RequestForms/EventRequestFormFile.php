<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventRequestFormFile extends Model
{
    use HasFactory;

    protected $fillable = ['file', 'name', 'event_request_form_id'];

    protected $table = 'arq_event_request_form_files';
}
