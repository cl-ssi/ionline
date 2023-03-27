<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rem extends Model
{
    protected $connection = 'mysql_rem';

    protected $year = null;

    public function setYear($year)
    {
        $this->year = $year;
        if($year != null){
            $this->table = $year.'rems';
        }
    }

    public static function year($year)
    {
        $instance = new static;
        $instance->setYear($year);
        return $instance->newQuery();
    }

    public function newInstance($attributes = array(), $exists = false)
    {
        $model = parent::newInstance($attributes, $exists);
        $model->setYear($this->year);
        return $model;
    }

    public function prestacion()
    {
        $instance = new Prestacion();
        $instance->setYear($this->year);
    
        return new BelongsTo($instance->newQuery(), $this, 'CodigoPrestacion', 'codigo_prestacion', 'prestacion');
    }

    public function establecimiento()
    {
        $instance = new Establecimiento();
        $instance->setYear($this->year);
    
        return new BelongsTo($instance->newQuery(), $this, 'IdEstablecimiento', 'Codigo', 'establecimiento');
    }
}
