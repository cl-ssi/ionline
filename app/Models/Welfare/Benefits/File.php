<?php

namespace App\Models\Welfare\Benefits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    
    protected $table = 'well_bnf_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'file', 'name', 'well_bnf_request_id'
    ];
}
