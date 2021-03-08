<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Percapita extends Model
{
    protected $connection = 'mysql_rem';

    protected $year = null;

    public function setYear($year)
    {
        $this->year = $year;
        if($year != null){
            $this->table = $year.'percapita';
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

    public function establecimiento()
    {
        $instance = new Establecimiento();
        $instance->setYear($this->year);

        // $foreignKey = $instance->getTable.'.'.$this->getForeignKey();
        // $localKey = $this->getKeyName();
    
        return new BelongsTo($instance->newQuery(), $this, 'COD_CENTRO', 'Codigo', 'establecimiento');
    }

    // public function __construct($attributes = [], $year = null) 
    // {
    //     parent::__construct($attributes);

    //     $year = $year ?: date('Y');

    //     $this->setTable($year.'rems');
    // }
}
