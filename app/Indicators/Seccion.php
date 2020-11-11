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
        $result = $this->subtotals_first ? 2 : 1; //para efectos de mostrar bien las celdas en tabla
        return $this->prestaciones->filter(function ($prestacion) use ($group){
            return Str::contains($prestacion->descripcion, '- '. $group . ' -');
        })->count() + ($this->subtotalExists($group) ? $result : 0);
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

    public function isLastPrestacionByGroup($item)
    {
        $prestaciones = $this->prestaciones->filter(function ($prestacion) use ($item){
            return Str::contains($prestacion->descripcion, '- '. $item->nombre_grupo_prestacion . ' -');
        });
        return $prestaciones->last() == $item;
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

    public function subtotalExists($group)
    {
        return Str::contains($this->subtotals, $group);
    }

    public function subtotal($col, $group)
    {
        $subtotal = 0;
        // foreach($this->subtotals_cods as $subtotal_cods)
        //     if(Str::contains($subtotal_cods, $cod))
        //         foreach($this->prestaciones as $prestacion)
        //             if(Str::contains($subtotal_cods, $prestacion->codigo_prestacion)) 
        //                 $subtotal += $prestacion->rems->sum($col);
        $prestaciones = $this->prestaciones->filter(function ($prestacion) use ($group){
            return Str::contains($prestacion->descripcion, '- '. $group . ' -');
        });
        foreach($prestaciones as $prestacion) $subtotal += $prestacion->rems->sum($col);
        return $subtotal;
    }
}