<div>
    <div class="dropdown">
        <button class="btn btn-secondary badge dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            Servicios
        </button>

        <div class="dropdown-menu">
            @foreach($services as $service)
            <a class="dropdown-item" href="#" wire:click="setService({{$service->id}})">
                <span 
                    class='badge badge-primary'>
                    {{ $service->name }}
                </span>
                @if(in_array($service->id, $roomServicesArray))
                <i class="fas fa-check"></i>
                @endif
            </a>
            @endforeach
        </div>

        @foreach($roomServices as $service)
        <span class='badge badge-primary'>
            <i class="fas fa-tag"></i> {{ $service->name }}
        </span>
        @endforeach

    </div>

</div>