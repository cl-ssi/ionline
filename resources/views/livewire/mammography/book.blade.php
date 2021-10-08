<div>
    @if($mammography->exam_date)
        <p><strong>Fecha:</strong> <i class="fas fa-calendar-day"></i> {{ $mammography->exam_date->format('d-m-Y H:i:s') }}.</p>

    {{--@elseif($mammography->first_dose) --}}
        <!-- <h5>Primera dósis:</h5>
        <p>Programada para el día <strong>{{-- $mammography->first_dose->format('d-m-Y \a \l\a\s H:i') --}} horas.</strong>
        Debe llegar 10 minutos ántes.</p> -->

    @else
        <div class="accordion" id="accordionExample">
        @foreach($days as $key => $day)
            @if($day->exam_available > $day->exam_used)
                  <div class="card">
                    <div class="card-header" id="headingOne-{{$key}}">
                      <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne-{{$key}}" aria-expanded="true" aria-controls="collapseOne">
                          <i class="fas fa-calendar-day"></i> {{ $day->day->format('d-m-Y') }} - ({{$day->exam_available - $day->exam_used }} cupos)
                        </button>
                      </h2>
                    </div>

                    <div id="collapseOne-{{$key}}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="card-body">
                        <ul class="list-group">
                        @foreach($day->slots as $slot)
                            <li class="list-group-item">
                                <i class="fas fa-clock"></i> {{ $slot->start_at->format('H:i') }} -
                                @if($slot->available > $slot->used)
                                    <button class="btn btn-sm btn-primary ml-3" wire:click="booking({{ $slot->id }})">Reservar</button>
                                @else
                                    <div style=""></div>
                                @endif
                            </li>
                        @endforeach
                        </ul>
                        <br>
                      </div>
                    </div>
                  </div>
            @endif
        @endforeach
        </div>
    @endif

</div>
