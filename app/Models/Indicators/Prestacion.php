<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Prestacion extends Model
{
    protected $connection = 'mysql_rem';

    protected $primaryKey = 'id_prestacion';

    protected $year = null;

    public function setYear($year)
    {
        $this->year = $year;
        if($year != null){
            $this->table = $year.'prestaciones';
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

        return new HasMany($instance->newQuery(), $this, 'CodigoPrestacion', 'codigo_prestacion');
    }

    public function getNombreSerieAttribute()
    {
        return head(explode(' - ', trim($this->descripcion)));
    }

    public function getNombrePrestacionAttribute()
    {
        return last(explode(' - ', trim($this->descripcion)));
    }

    public function getNombreGrupoPrestacionAttribute()
    {
        $array = explode(' - ', trim($this->descripcion));
        end($array);
        return prev($array);
    }

    public function getNombreSuperGrupoPrestacionAttribute()
    {
        $array = explode(' - ', trim($this->descripcion));
        end($array);
        prev($array);
        return prev($array);
    }

    public function hasGroup($maxLevel)
    {
        return $this->countLevel() == $maxLevel;
    }

    public function countLevel()
    {
        return count(explode(' - ', trim($this->descripcion)));
    }

    public static function exists($year)
    {
        return Schema::connection('mysql_rem')->hasTable($year.'prestaciones');
    }
}
