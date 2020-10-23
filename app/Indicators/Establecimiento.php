<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    protected $connection = 'mysql_rem';

    protected $primaryKey = 'id_establecimiento';

    protected $year = null;

    public function setYear($year)
    {
        $this->year = $year;
        if($year != null){
            $this->table = $year.'establecimientos';
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
}
