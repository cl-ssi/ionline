<div>
    @if($mammography->exam_date)
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Reserva</strong>
            </div>
            <div class="card-body">
                <p><strong>Fecha:</strong> <i class="fas fa-calendar-day"></i> {{ $mammography->exam_date->format('d-m-Y H:i:s') }}.</p>
                <p><strong>Lugar:</strong> <i class="fas fa-hospital"></i> Servicio de Imageneología Hospital Dr. Ernesto Torres G. - Iquique.</p>
            </div>
        </div>
    {{--@elseif($mammography->first_dose) --}}
        <!-- <h5>Primera dósis:</h5>
        <p>Programada para el día <strong>{{-- $mammography->first_dose->format('d-m-Y \a \l\a\s H:i') --}} horas.</strong>
        Debe llegar 10 minutos ántes.</p> -->

    @else
        <div class="accordion" id="accordionExample">
        @foreach($days->where('day', '>=', \Carbon\Carbon::now()) as $key => $day)
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
                        @foreach($day->slots as $key => $slot)
                            <li class="list-group-item">
                                <i class="fas fa-clock"></i> {{ $slot->start_at->format('H:i') }}
                                @if($slot->available > $slot->used)
                                    <form wire:submit="booking({{ $slot->id }})" method="POST">
                                        <div class="form-row col-md-4">
                                          <label for="for_legal_quality" >Teléfono</label>
                                          <div class="input-group">
                                              <input type="text" class="form-control" name="telephone" id="for_telephone"  placeholder="+569xxxxxxxx"
                                                  wire:model.live="telephone" required>
                                              <button class="btn btn-sm btn-primary ml-3">Reservar</button>
                                          </div>
                                        </div>
                                    </form>
                                    <!-- <button class="btn btn-sm btn-primary ml-3" wire:click="booking({{ $slot->id }})">Reservar</button> -->
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
