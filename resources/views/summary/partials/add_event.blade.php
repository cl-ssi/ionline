<div class="card mb-3">
    <div class="card-header text-white bg-success pb-0">
        <h5 class="card-title">Agregar nuevo paso</h5>
    </div>
    <div class="card-body">
        @if ($childs)
            <form action="{{ route('summary.event.store', ['summary' => $summary, 'event' => $event]) }}" method="post">
        @else
            <form action="{{ route('summary.event.store', ['summary' => $summary, 'event' => null]) }}" method="post">
        @endif

        @csrf
        @method('POST')

        <div class="row">
            <div class="col">
                <select name="event_type_id" id="" class="form-control">
                    <option value=""></option>
                    @foreach ($links as $linkAfter)
                        <option value="{{ $linkAfter->afterEvent->id }}">
                            {{ $linkAfter->afterEvent->name ?? '' }} 
                            {{ $linkAfter->afterEvent->duration ? '('.$linkAfter->afterEvent->duration . ' días)' : '' }} 
                            {{ $linkAfter->afterEvent->description ? '('.$linkAfter->afterEvent->description.')' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-success form-control">Agregar</button>
            </div>
        </div>
        </form>
    </div>
</div>
