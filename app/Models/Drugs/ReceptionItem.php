<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceptionItem extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'substance_id',
        'nue',
        'sample_number',
        'document_weight',
        'gross_weight',
        'net_weight',
        'estimated_net_weight',
        'sample',
        'countersample_number',
        'countersample',
        'destruct',
        'equivalent',
        'result_number',
        'result_date',
        'result_substance_id',
        'dispose_precursor',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['result_date', 'deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_reception_items';

    protected $casts = [
        'dispose_precursor' => 'boolean',
    ];

    public function reception()
    {
        return $this->belongsTo(Reception::class);
    }

    public function substance()
    {
        return $this->belongsTo(Substance::class);
    }

    public function resultSubstance()
    {
        return $this->belongsTo(Substance::class, 'result_substance_id');
    }

    public function protocols()
    {
        return $this->hasMany(Protocol::class);
    }

    public function getLetterAttribute()
    {
        $position = "";
        $position = $this->reception->items->search(function($receptionItem) {
            return $receptionItem->id == $this->id;
        });
        return$this->position($position + 1);
    }

    public function position($position)
    {
        $letter = "";
        switch($position) {
            case 1:
                $letter = "a";
                break;
            case 2:
                $letter = "b";
                break;
            case 3:
                $letter = "c";
                break;
            case 4:
                $letter = "d";
                break;
            case 5:
                $letter = "e";
                break;
            case 6:
                $letter = "f";
                break;
            case 7:
                $letter = "g";
                break;
            case 8:
                $letter = "h";
                break;
            case 9:
                $letter = "i";
                break;
            case 10:
                $letter = "j";
                break;
            case 11:
                $letter = "k";
                break;
            case 12:
                $letter = "l";
                break;
            case 13:
                $letter = "m";
                break;
            case 14:
                $letter = "n";
                break;
            case 15:
                $letter = "o";
                break;
            case 16:
                $letter = "p";
                break;
            case 17:
                $letter = "q";
                break;
            case 18:
                $letter = "r";
                break;
            case 19:
                $letter = "s";
                break;
            case 20:
                $letter = "t";
                break;
            case 21:
                $letter = "u";
                break;
            case 22:
                $letter = "v";
                break;
            case 23:
                $letter = "w";
                break;
            case 24:
                $letter = "x";
                break;
            case 25:
                $letter = "y";
                break;
            case 26:
                $letter = "z";
                break;
        }

        if($position <= 26)
        {
            return $letter;
        }
        else
        {
            return $this->position((int)($position / 26)).$this->position($position % 26);
        }
    }
}
