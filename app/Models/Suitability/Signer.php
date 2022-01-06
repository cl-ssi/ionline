<?php

namespace App\Models\Suitability;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'psi_signers';

        protected $dates = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        protected $fillable = [
        'user_id',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeEspAttribute()
    {
        switch ($this->type) {
            case 'visator':
                return 'Visador';
                break;
            
            case 'signer':
                return 'Firmante';
                break;

            default:
                return '';
                break;
        }
    }

}
