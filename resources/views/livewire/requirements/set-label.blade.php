<div>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-tags"></i>
        </button>

        <div class="dropdown-menu">
            @foreach(auth()->user()->reqLabels as $label)
            <a class="dropdown-item" href="#" wire:click="setLabel({{$label->id}})">
                <span 
                    class='badge badge-primary' 
                    style='background-color: #{{ $label->color }};'>
                    {{ $label->name }}
                </span>
                @if(in_array($label->id, $reqLabelsArray))
                <i class="fas fa-check"></i>
                @endif
            </a>
            @endforeach
        </div>

        @foreach($reqLabels as $label)
        <span 
            class='badge badge-primary' 
            style='background-color: #{{ $label->color }};'>
            <i class="fas fa-tag"></i> {{ $label->name }}
        </span>
        @endforeach

    </div>

</div>