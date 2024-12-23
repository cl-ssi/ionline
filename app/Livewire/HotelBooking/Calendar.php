<?php

namespace App\Livewire\HotelBooking;

use Livewire\Attributes\On;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Parameters\Holiday;
use App\Models\HotelBooking\Room;
use App\Models\HotelBooking\RoomBooking;

class Calendar extends Component
{

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

    public $room;
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
        $this->configurations = Room::find($this->room->id)->bookingConfigurations->where('end_date','>=',now());

        $string = $this->monthSelection;
        $monthSelection = Carbon::createFromFormat('Y-m-d', $this->monthSelection."-15");
        $this->startOfMonth = $monthSelection->startOfMonth();
        $this->endOfMonth = $this->startOfMonth->copy()->endOfMonth();
    }

    #[On('ExecRender')]
    public function ExecRender($room){
        // si se guarda uno nuevo, se busca y se guarda en variable local
        if($room){
            $this->configurations = Room::find($room['id'])->bookingConfigurations;
        }
        
        $this->render();
    }

    public function MonthUpdate(){
        $string = $this->monthSelection;
        $monthSelection = Carbon::createFromFormat('Y-m-d', $this->monthSelection."-15");
        $this->startOfMonth = $monthSelection->startOfMonth();
        $this->endOfMonth = $this->startOfMonth->copy()->endOfMonth();
        
    }

    public function render()
    {
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);

        $this->data = [];
        $this->blankDays = ($this->startOfMonth->dayOfWeek == 0) ? 7 : $this->startOfMonth->dayOfWeek;

        $holidays = Holiday::whereBetween('date', [$this->startOfMonth, $this->endOfMonth])
            ->get();

        foreach (CarbonPeriod::create($this->startOfMonth, '1 day', $this->endOfMonth) as $day) {
            $this->data[$day->format('Y-m-d')] = array(
                'holiday' => false,
                'date' => $day,
                'active' => false,
                'style' => null,
                'user' => null,
            );
        }

        foreach($this->configurations as $configuration){
            foreach (CarbonPeriod::create($configuration->start_date, '1 day', $configuration->end_date->endOfDay()) as $day) {
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
                            'user' => null,
                        );
                    }
                }
            }
        }

        // dd($this->data);
        
        // marca los días ya ocupados
        $rooms_array = $this->configurations->pluck('room_id')->toArray();
        $roomBookings = RoomBooking::whereIn('status',['Reservado','Confirmado','Bloqueado'])
                                    ->whereIn('room_id',$rooms_array)
                                    ->where(function($query) {
                                        $query->whereBetween('start_date', [$this->startOfMonth, $this->endOfMonth])
                                            ->orwhereBetween('end_date', [$this->startOfMonth, $this->endOfMonth]);
                                    })
                                    ->get()
                                    ->sortBy('start_date');

        foreach($roomBookings as $key => $roomBooking){
            foreach (CarbonPeriod::create($roomBooking->start_date, '1 day', $roomBooking->end_date) as $day) {
                
                // verifica primero si el tiene style, es decir si está configurado para ser reservado en las configuraciones
                if(array_key_exists($day->format('Y-m-d'), $this->data)){                    
                    //verifica el usuario configurado para ese día
                    if(auth()->user()->hasPermissionTo('HotelBooking: Administrador')){

                        if($this->data[$day->format('Y-m-d')]['user']!=null){
                            $user = $this->data[$day->format('Y-m-d')]['user'] . "\n Ingresa: " . $roomBooking->user->tinyName;
                        }else{
                            if($day->format('Y-m-d') == $roomBooking->start_date->format('Y-m-d')){
                                $user = "Ingresa: " . $roomBooking->user->tinyName;
                            }  
                            else{
                                $user = "Sale: " . $roomBooking->user->tinyName;
                            }  
                        }

                    }else{
                        $user = '';
                    }

                    if($this->data[$day->format('Y-m-d')]['style']!=null){
                        // default
                        $this->style='red_middle_style';
                        $this->data[$day->format('Y-m-d')] = array(
                            'holiday' => false,
                            'date' => $day,
                            'active' => false,
                            'style' => $this->style,
                            'user' => $user,
                        );
                        // revisa inicio de la reserva de la primera iteración
                        if($key==0){
                            if($day->format('Y-m-d')==$roomBooking->start_date->format('Y-m-d')){
                                $this->style='red_start_style';
                                $this->data[$day->format('Y-m-d')] = array(
                                    'holiday' => false,
                                    'date' => $day,
                                    'active' => false,
                                    'style' => $this->style,
                                    'user' => $user,
                                );
                            }
                        }
                        // revisa inicio de la reserva de las iteraciones siguientes (hace la comparativa con terminos de reservas anteriores)
                        if($key>0 && $roomBookings[$key-1]->end_date != $day){
                            if($day->format('Y-m-d')==$roomBooking->start_date->format('Y-m-d')){
                                $this->style='red_start_style';
                                $this->data[$day->format('Y-m-d')] = array(
                                    'holiday' => false,
                                    'date' => $day,
                                    'active' => false,
                                    'style' => $this->style,
                                    'user' => $user,
                                );
                            }
                        }
                        // revisa terminos de reservas
                        if($day->format('Y-m-d')==$roomBooking->end_date->format('Y-m-d')){
                            $this->style='red_end_style';
                            $this->data[$day->format('Y-m-d')] = array(
                                'holiday' => false,
                                'date' => $day,
                                'active' => false,
                                'style' => $this->style,
                                'user' => $user,
                            );
                        }
                    }
                }
            }

            // // pinta para la reserva que se está solicitando
            // foreach (CarbonPeriod::create($start_date, '1 day', $end_date) as $day) {
            //     // default
            //     $this->style='middle_style';
            //     $this->data[$day->format('Y-m-d')] = array(
            //         'holiday' => false,
            //         'date' => $day,
            //         'active' => false,
            //         'style' => $this->style,
            //     );
            // }
        }

        foreach ($holidays as $holiday) {
            $this->data[$holiday->date->format('Y-m-d')]['holiday'] = true;
        }

        return view('livewire.hotel-booking.calendar');
    }

}
