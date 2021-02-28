<div>
    @if($vaccination->first_dose_at)
        <h5>Primera dósis:</h5>
        <p>Suministrada el día <strong>{{ $vaccination->first_dose_at->format('d-m-Y') }}.</strong></p>

    @elseif($vaccination->first_dose)
        <h5>Primera dósis:</h5>
        <p>Programada para el día <strong>{{ $vaccination->first_dose->format('d-m-Y \a \l\a\s H:i') }} horas.</strong>
        Debe llegar 10 minutos ántes.</p>
    
    @else
        <h5>Primera dósis:</h5>
        <p>Reserve su hora a continuación:</p>
        
        <table>
            <tr>
        @foreach($days as $day)
            @if($day->first_dose_available > $day->first_dose_used)
            <td>
                <strong>{{ $day->day->format('d-m-Y') }}</strong> <br>
                ({{ $day->first_dose_available - $day->first_dose_used }} cupos)
                <ul class="list-group">
                @foreach($day->slots as $slot)
                    <li class="list-group-item text-center">
                    {{ $slot->start_at->format('H:i') }} <br>
                    @if($slot->available > $slot->used) 
                        <button class="btn btn-sm btn-primary ml-3" wire:click="bookingFirst({{ $slot->id }})">Reservar</button>
                    @else
                        <div style="height: 31px;"></div>
                    @endif
                    </li>
                @endforeach
                </ul>
            </td>
            @endif
        @endforeach
        </tr>
        </table>
        
        <br>
    @endif



    @if($vaccination->first_dose_at)
        @if($vaccination->second_dose_at)
            <h5>Segunda dósis:</h5>
            <p>Suministrada el día <strong>{{ $vaccination->second_dose_at->format('d-m-Y \a \l\a\s H:i') }} horas.</strong></p>
        
        @elseif($vaccination->second_dose)
            <h5>Segunda dósis:</h5>
            <p>Programada para el día <strong>{{ $vaccination->second_dose->format('d-m-Y \a \l\a\s H:i') }} horas.</strong>
            Debe llegar 10 minutos ántes.</p>
        
        @else
            <h5>Segunda dósis:</h5>
            <p>Reserve su hora a continuación:</p>
            @if(empty($slots))
                <h5 class="text-danger">No hay horas disponibles para agendar</h5>
                <hr>
            @else
                <table>
                <tr>
                @foreach($days as $day)
                    <td>
                        <strong>{{ $day->day->format('d-m-Y') }}</strong>
                        <ul class="list-group">
                        @foreach($day->slots as $slot)
                            <li class="list-group-item text-center">
                            {{ $slot->start_at->format('H:i') }} <br> 
                            @if($slot->available > $slot->used)
                                <button class="btn btn-sm btn-primary ml-3" wire:click="bookingSecond({{ $slot->id }})" onclick="return false;">Reservar</button>
                            @else
                                <div style="height: 31px;"></div>
                            @endif
                            ({{ $slot->available - $slot->used }} cupos)
                            </li>
                        @endforeach
                        </ul>
                    </td>
                @endforeach
                </tr>
                </table>
                <br>
            @endif
        @endif
    @endif
</div>