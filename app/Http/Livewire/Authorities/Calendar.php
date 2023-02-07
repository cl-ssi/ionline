<?php

namespace App\Http\Livewire\Authorities;

use Livewire\Component;
use Carbon\Carbon;
use App\User;
use App\Rrhh\OrganizationalUnit;

class Calendar extends Component
{
    public $organizationalUnit;
    public $date = null;
    public $type = null;

    /** Input selector de mes */
    public $monthSelection;

    /** Primer día del mes seleccionado */
    public $startOfMonth;

    /** Array con los datos para imprimir el calendario */
    public $data;

    /** Flag para mostrar o no el cuadro de editar */
    public $editForm = false;

    public $today;

    /**
    * Mount
    */
    public function mount(OrganizationalUnit $organizationalUnit)
    {
        $this->organizationalUnit = $organizationalUnit;
        $this->monthSelection = date('Y-m');

        $this->today = now()->format('Y-m-d');
    }

    /**
    * Muestra formulario para editar una autoridad en una fecha
    */
    public function edit($date,$type)
    {
        $this->editForm = true;
        $this->date = $date;
        $this->type = $type;
    }

    /**
    * Guarda la edición de una autoridad
    */
    public function save()
    {
        $this->editForm = false;
    }

    public function render()
    {

        $this->startOfMonth = Carbon::createFromFormat('Y-m', $this->monthSelection)->startOfMonth();
        
        /** Array de prueba */

        // array:6 [▼
        //     "2023-02-01" => array:4 [▼
        //         "date" => Carbon\Carbon @1675220400 {#3274 ▶}
        //         "holliday" => false
        //         "manager" => App\User {#3296 ▶}
        //         "secretary" => App\User {#3303 ▶}
        //     ]
        //     "2023-02-02" => array:4 [▼
        //         "date" => Carbon\Carbon @1675306800 {#3246 ▶}
        //         "holliday" => true
        //         "manager" => App\User {#3311 ▶}
        //         "secretary" => App\User {#3318 ▶}
        //     ]
        //     "2023-02-03" => array:4 [▼
        //         "date" => Carbon\Carbon @1675393200 {#3255 ▶}
        //         "holliday" => false
        //         "manager" => App\User {#3326 ▶}
        //         "secretary" => App\User {#3333 ▶}
        //     ]
        //     "2023-02-04" => array:4 [▼
        //         "date" => Carbon\Carbon @1675479600 {#3304 ▶}
        //         "holliday" => false
        //         "manager" => App\User {#3341 ▶}
        //         "secretary" => App\User {#3348 ▶}
        //     ]
        //     "2023-02-05" => array:4 [▼
        //         "date" => Carbon\Carbon @1675566000 {#3319 ▶}
        //         "holliday" => false
        //         "manager" => App\User {#3356 ▶}
        //         "secretary" => App\User {#3363 ▶}
        //     ]
        //     "2023-02-06" => array:4 [▼
        //         "date" => Carbon\Carbon @1675652400 {#3334 ▶}
        //         "holliday" => false
        //         "manager" => App\User {#3371 ▶}
        //         "secretary" => App\User {#3378 ▶}
        //     ]
        // ]
        $this->data = array();

        $date = $this->startOfMonth->copy();
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(1);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = true;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);
        
        $date = $this->startOfMonth->copy()->addDays(2);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(3);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(4);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(5);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(6);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        $date = $this->startOfMonth->copy()->addDays(7);
        $this->data[$date->format('Y-m-d')]['date'] = $date;
        $this->data[$date->format('Y-m-d')]['holliday'] = false;
        $this->data[$date->format('Y-m-d')]['manager'] = User::find(15287582);
        $this->data[$date->format('Y-m-d')]['secretary'] = User::find(15287582);

        return view('livewire.authorities.calendar');
    }
}
