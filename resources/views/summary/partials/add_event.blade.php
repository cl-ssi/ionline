<div class="card">
    <div class="card-header text-white bg-success">
        <h5 class="card-title">Agregar nuevo evento</h5>
    </div>
    <div class="card-body">
        
        <div class="row">
            <div class="col">
                <select name="" id="" class="form-control">
                    <option value=""></option>
                    @foreach ($event->type->linksAfter as $linkAfter)
                        <option
                        value="{{ $linkAfter->afterEvent->id }}">
                        {{ $linkAfter->afterEvent->name ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-2">
                <button class="btn btn-success form-control">Agregar</button>
            </div>
        </div>
    </div>
</div>