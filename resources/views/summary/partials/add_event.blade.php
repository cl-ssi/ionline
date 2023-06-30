<div class="card">
    <div class="card-header text-white bg-success">
        <h5 class="card-title">Agregar nuevo paso</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('summary.event.store',[$summary, $event]) }}" method="post">
            @csrf
            @method('POST')

            <div class="row">
                <div class="col">
                    <select name="event_type_id" id="" class="form-control">
                        <option value=""></option>
                        @foreach ($links as $linkAfter)
                        <option
                        value="{{ $linkAfter->afterEvent->id }}">
                        {{ $linkAfter->afterEvent->name ?? '' }}
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