<?php

namespace App\Http\Livewire\HotelBooking;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\Parameters\Holiday;
use App\Models\HotelBooking\RoomBookingConfiguration;
use App\Models\HotelBooking\Room;
use App\Models\HotelBooking\RoomBooking;

class Calendar extends Component
{

    protected $listeners = ['ExecRender' => 'ExecRender'];

    public $date = null;
    public $type = null;

    public $start_date;
    public $end_date;
    public $style = null;

    /** Input selector de mes */
    public $monthSelection;

    /** Primer día del mes seleccionado */
    public $startOfMonth;

    /** Último día del mes seleccionado */
    public $endOfMonth;

    /** Array con los datos para imprimir el calendario */
    public $data;

    public $today;

    /** Cantidad de cuadros en blanco antes del primer día del mes */
    public $blankDays;

    public $configurations;

    /**
     * Mount
     */
    public function mount()
    {
        $this->monthSelection = date('Y-m');
        if($this->start_date){
            $start_date = Carbon::parse($this->start_date);
            $this->monthSelection = $start_date->format('Y-m');
        }
        $this->today = now()->format('Y-m-d');
        // $this->today = $this->configurations->first()->start_date->format('Y-m-d');
        
    }

    public function ExecRender($room){
        // si se guarda uno nuevo, se busca y se guarda en variable local
        if($room){
            $this->configurations = Room::find($room['id'])->bookingConfigurations;
        }
        
        $this->render();
    }

    public function render()
    {
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);

        $this->data = [];
        $this->startOfMonth = Carbon::createFromFormat('Y-m', $this->monthSelection)->startOfMonth();
        $this->endOfMonth = $this->startOfMonth->copy()->endOfMonth();

        $this->blankDays = ($this->startOfMonth->dayOfWeek == 0) ? 7 : $this->startOfMonth->dayOfWeek;

        $holidays = Holiday::whereBetween('date', [$this->startOfMonth, $this->endOfMonth])
            ->get();

        foreach (CarbonPeriod::create($this->startOfMonth, '1 day', $this->endOfMonth) as $day) {
            $this->data[$day->format('Y-m-d')] = array(
                'holiday' => false,
                'date' => $day,
                'active' => false,
                'style' => null,
            );
        }

        foreach($this->configurations as $configuration){
            foreach (CarbonPeriod::create($configuration->start_date, '1 day', $configuration->end_date) as $day) {
                // marca los disponibles para hospedar
                if(( $configuration->sunday && $day->dayOfWeek==0) || ($configuration->monday && $day->dayOfWeek==1) || 
                    ($configuration->tuesday && $day->dayOfWeek==2) || ($configuration->wednesday && $day->dayOfWeek==3) || 
                    ($configuration->thursday && $day->dayOfWeek==4) || ($configuration->friday && $day->dayOfWeek==5) ||
                    ($configuration->saturday && $day->dayOfWeek==6)){

                    // si es dia pasado, se marca con rojo, si no, verde
                    if($day->format('Y-m-d') < now()->format('Y-m-d')){$this->style='not_available_style';}
                    else{$this->style='active_style';}

                    // se agrega solo si esta dentro del mes que se seleccionó en la vista
                    if(array_key_exists($day->format('Y-m-d'), $this->data)){
                        $this->data[$day->format('Y-m-d')] = array(
                            'holiday' => false,
                            'date' => $day,
                            'active' => true,
                            'style' => $this->style,
                        );
                    }
                }
            }

            // marca los días ya ocupados
            $roomBookings = RoomBooking::where('start_date','>=',$configuration->start_date)->where('room_id',$configuration->room_id)->get();
            foreach($roomBookings as $roomBooking){
                foreach (CarbonPeriod::create($roomBooking->start_date, '1 day', $roomBooking->end_date) as $day) {
                    $this->style='red_middle_style';
                    if($day->format('Y-m-d')==$start_date->format('Y-m-d')){$this->style='red_start_style';}
                    if($day->format('Y-m-d')==$end_date->format('Y-m-d')){$this->style='red_end_style';}
                    if(array_key_exists($day->format('Y-m-d'), $this->data)){
                        $this->data[$day->format('Y-m-d')] = array(
                            'holiday' => false,
                            'date' => $day,
                            'active' => false,
                            'style' => $this->style,
                        );
                    }
                }
            }

            //se marcan dias propuestos para reservar
            $this->style='middle_style';
            if($this->start_date){
                foreach (CarbonPeriod::create($this->start_date, '1 day', $this->end_date) as $day) {
                    if(array_key_exists($day->format('Y-m-d'), $this->data)){
                        $this->data[$day->format('Y-m-d')] = array(
                            'holiday' => false,
                            'date' => $day,
                            'active' => false,
                            'style' => $this->style,
                        );
                    }
                }
            }
            
        }

        foreach ($holidays as $holiday) {
            $this->data[$holiday->date->format('Y-m-d')]['holiday'] = true;
        }

        return view('livewire.hotel-booking.calendar');
    }

}
