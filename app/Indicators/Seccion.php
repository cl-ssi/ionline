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
        $result = $this->subtotals_first ? 2 : 1; //para efectos de mostrar bien los subtotales en las celdas de la tabla
        return $this->prestaciones->filter(function ($prestacion) use ($group){
            return Str::contains($prestacion->descripcion, '- '. $group . ' -');
        })->count() + ($this->subtotalExists($group) ? $result : 0);
    }

    public function hasGroup()
    {
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

    public function supergroupExists($supergroup)
    {
        return Str::contains($this->supergroups, $supergroup);
    }

    public function isSupergroupWithSubtotals($supergroup)
    {
        $prestaciones = $this->prestaciones->filter(function ($prestacion) use ($supergroup){
            return Str::contains($prestacion->descripcion, '- '. $supergroup . ' -');
        });
        foreach($prestaciones as $prestacion) if($this->subtotalExists($prestacion->nombre_grupo_prestacion)) return true;
        return false;
    }

    public function subtotal($col, $group)
    {
        $subtotal = 0;
        $prestaciones = $this->prestaciones->filter(function ($prestacion) use ($group){
            return Str::contains($prestacion->descripcion, '- '. $group . ' -');
        });
        foreach($prestaciones as $prestacion) $subtotal += $prestacion->rems->sum($col);
        return $subtotal;
    }
}