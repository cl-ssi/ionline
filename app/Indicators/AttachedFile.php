<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachedFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ind_values_attached_files';
    protected $fillable = [
        'file', 'document_name', 'value_id'
    ];


}
