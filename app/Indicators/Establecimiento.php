<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function rems()
    {
        $instance = new Rem();
        $instance->setYear($this->year);

        // $foreignKey = $instance->getTable.'.'.$this->getForeignKey();
        // $localKey = $this->getKeyName();

        return new HasMany($instance->newQuery(), $this, 'IdEstablecimiento', 'Codigo');
    }
}
