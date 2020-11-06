<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seccion extends Model
{
    protected $connection = 'mysql_rem';

    protected $primaryKey = 'id';

    protected $year = null;

    public function setYear($year)
    {
        $this->year = $year;
        if($year != null){
            $this->table = $year.'secciones';
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

    public function getCountPrestacionBy($group)
    {
        return $this->prestaciones->filter(function ($prestacion) use ($group){
            return Str::contains($prestacion->descripcion, $group . ' -');
        })->count();
    }

    public function hasGroup()
    {
        // foreach($this->prestaciones as $prestacion)
        //     if($prestacion->hasGroup()) return true;
        // return false;
        $levels = collect();
        foreach($this->prestaciones as $prestacion) $levels->push($prestacion->countLevel());
        return $levels->min() != $levels->max() OR $levels->min() >= 3;
    }

    public function maxLevel()
    {
        $levels = collect();
        foreach($this->prestaciones as $prestacion) $levels->push($prestacion->countLevel());
        return $levels->max();
    }

    public function total($col)
    {
        $total = 0;
        foreach($this->prestaciones as $prestacion) $total += $prestacion->rems->sum($col);
        return $total;
    }
}
