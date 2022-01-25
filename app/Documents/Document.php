<?php

namespace App\Documents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use OwenIt\Auditing\Contracts\Auditable;


class Document extends Model implements Auditable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;


    protected $fillable = [
        'number', 'date', 'type', 'antecedent', 'responsible', 'subject',
        'from', 'for', 'greater_hierarchy', 'distribution', 'content', 'file_to_sign_id',

    ];

    public function getFromHtmlAttribute()
    {
        return str_replace("/", "<br>", $this->from);
    }

    public function getFromHtmlSignAttribute()
    {
        /* Esta funcion elimina del firmante la frase "SERVICIO DE SALUD IQUIQUE"
           para evitar que salga duplicado en la firmante
           */
        $chars    = array("/", "SERVICIO DE SALUD IQUIQUE", "Servicio de Salud Iquique");
        $htmlchar = array("<br>", "", "");

        return str_replace($chars, $htmlchar, $this->from);
    }

    public function getForHtmlAttribute()
    {
        return str_replace("/", "<br>", $this->for);
    }

    public function getAntecedentHtmlAttribute()
    {
        return str_replace("/", "<br>", $this->antecedent);
    }

    public function getResponsiblesArrayAttribute()
    {
        return explode("\n",$this->responsible);
    }

    public function getResponsibleHtmlAttribute()
    {
        return str_replace("\n", "<br>", $this->responsible);
    }

    public function getContentHtmlAttribute()
    {
        return str_replace("<!-- pagebreak -->", '<div style="page-break-after: always;"></div>', $this->content);
    }

    public function getDistributionHtmlAttribute()
    {
        $chars    = array("<", ">", "\n");
        $htmlchar = array("&lt;", "&gt;", "<br>");

        return str_replace($chars, $htmlchar, $this->distribution);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function user() {
            return $this->belongsTo('App\User')->withTrashed();
    }

    public function organizationalUnit() {
            return $this->belongsTo('App\Rrhh\OrganizationalUnit');
    }

    public function scopeSearch($query, Request $request) {
        if($request->input('id') != "") {
            $query->where('id', $request->input('id') );
        }

        if($request->input('type') != "") {
            $query->where('type', 'LIKE', '%'.$request->input('type').'%' );
        }

        if($request->input('number') != "") {
            $query->where('number', 'LIKE', '%'.$request->input('number').'%' );
        }

        if($request->input('subject') != "") {
            $query->where('subject', 'LIKE', '%'.$request->input('subject').'%' );
        }

        if($request->input('user_id') != "") {
            $query->where('user_id', $request->input('user_id') );
        }

        if($request->input('file') != "") {
            $query->where('file', null );
        }

        return $query;
    }

    // public function reqEvents() {
    //     return $this->belongsToMany('App\Requirements\EventDocument');
    // }

    public function reqEvents() {
        return $this->belongsToMany('App\Requirements\Event','req_documents_events');
    }

    public function fileToSign()
    {
        return $this->belongsTo('App\Models\Documents\SignaturesFile', 'file_to_sign_id');
    }


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'date'];
}
