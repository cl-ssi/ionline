<?php

namespace App\Models\Documents;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Establishment;
use App\Models\Documents\Type;

class Parte extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'type_id',
        'reserved',
        'number',
        'origin',
        'subject',
        'important',
        'entered_at',
        'viewed_at',
        'physical_format',
        'received_by_id',
        'establishment_id',
        'reception_date',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date',
        'deleted_at',
        'viewed_at',
    ];

    public function events()
    {
        return $this->hasMany('\App\Models\Documents\ParteEvent');
    }

    public function requirements()
    {
        return $this->hasMany('\App\Requirements\Requirement');
    }

    public function files()
    {
        return $this->hasMany('App\Models\Documents\ParteFile');
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class)->withTrashed();
    }


    /* FIXME: Esto no es necesario */
    public function getCreationParteDateAttribute()
    {
        return Carbon::parse($this->date)->format('d-m-Y');
    }

    public function scopeFilter($query, $column, $value) {
        if(!empty($value)) {
            switch($column) {
                case 'origin':
                case 'subject':
                    $query->where($column, 'LIKE', '%'.$value.'%');
                    break;
                case 'id':
                case 'number':
                case 'type_id':
                    $query->where($column, $value);
                    break;
                case 'without_sgr':
                    $query->whereDoesntHave('requirements');
                    $query->whereDate('created_at', '>=', date('Y') - 1 .'-01-01');
                    break;
                case 'important':
                    $query->whereNotNull('important');
                    break;
            }
        }

    }

    public function scopeSearch($query, Request $request)
    {
        if($request->input('id') != "") {
            $query->where('id', $request->input('id') );
        }

        if($request->input('type') != "") {
            $query->where('type', $request->input('type') );
        }

        if($request->input('number') != "") {
            $query->where('number', 'LIKE', '%'.$request->input('number').'%' );
        }

        if($request->input('origin') != "") {
            $query->where('origin', 'LIKE', '%'.$request->input('origin').'%' );
        }

        if($request->input('subject') != "") {
            $query->where('subject', 'LIKE', '%'.$request->input('subject').'%' );
        }
        
        if($request->input('without_sgr') != "") {
            $query->whereDoesntHave('requirements');
            $query->whereDate('created_at', '>=', date('Y') - 1 .'-01-01');
        }

        return $query;
    }

    /* FIXME: cambiar nombre */
    public function scopeSearch2($query, $request)
    {
        if($request != "") {
            $query->where('number','LIKE','%'.$request.'%')
                  ->orWhere('origin','LIKE','%'.$request.'%');
        }

        return $query;
    }
}
