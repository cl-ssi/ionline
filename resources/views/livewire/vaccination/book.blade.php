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
        
        @foreach($days as $day)
            @if($day->first_dose_available > $day->first_dose_used)
                <strong>{{ $day->day->format('d-m-Y') }}</strong> 
                ({{$day->first_dose_available - $day->first_dose_used }} cupos)
                <ul class="list-group">
                @foreach($day->slots as $slot)
                    <li class="list-group-item">
                        {{ $slot->start_at->format('H:i') }} - 
                        @if($slot->available > $slot->used)
                            <button class="btn btn-sm btn-primary ml-3" wire:click="bookingFirst({{ $slot->id }})">Reservar</button> 
                        @else
                            <div style=""></div>
                        @endif
                    </li>
                @endforeach
                </ul>
                <br>
            @endif
        @endforeach

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
                <h4>{{ $slots->first()->day->day->format('d-m-Y') }}</h4>
                <ul class="list-group">
                @foreach($slots as $slot) 
                    <li class="list-group-item">
                        {{ $slot->start_at->format('H:i') }} - 
                        @if($slot->available > $slot->used)
                            <button class="btn btn-sm btn-primary ml-3" wire:click="bookingSecond({{ $slot->id }})">Reservar</button> 
                        @else
                            <div style=""></div>
                        @endif
                    </li>
                @endforeach
                </ul>
                <br>
            @endif
        @endif
    @endif
</div>