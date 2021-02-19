<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'previous_experience', 'performed_functions', 'file', 'contact_name',
        'contact_telephone', 'replacement_staff_id'
    ];

    public function replacement_staff() {
        return $this->belongsTo('App\Models\ReplacementStaff\ReplacementStaff');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_experiences';
}
