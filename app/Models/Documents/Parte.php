<?php

namespace App\Models\Documents;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Establishment;
use App\Models\Documents\Type;
use App\Models\Documents\Correlative;

class Parte extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'correlative',
        'entered_at',
        'type_id',
        'reserved',
        'date',
        'number',
        'origin',
        'subject',
        'important',
        'physical_format',
        'received_by_id',
        'establishment_id',
        'reception_date',
        'viewed_at',
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
        return $this->hasMany('\App\Models\Requirements\Requirement');
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


    public function setCorrelative() {
        abort_if(!isset($this->establishment_id), 501,'El parte no tiene establecimiento asociado');

        /* Obtener el objeto correlativo según el tipo */
        $correlative = Correlative::whereNull('type_id')
            ->where('establishment_id',$this->establishment_id)
            ->first();

        if(!$correlative) {
            $correlative = Correlative::create([
                'type_id' => null,
                'correlative' => 1,
                'establishment_id' => $this->establishment_id
            ]);
        }

        /* Almacenar el número del correlativo  */
        $number = $correlative->correlative;

        /* Aumentar el correlativo y guardarlo */
        $correlative->correlative += 1;
        $correlative->save();

        /* Almacenar el correlativo en el parte */
        $this->correlative = $number;
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
