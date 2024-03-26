<div>
    <h3>Prestaciones</h3>

    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
        <textarea wire:model.defer="prestaciones" class="form-control" id="exampleFormControlTextarea1" rows="10"></textarea>
    </div>
    <button type="submit" class="btn btn-primary" wire:click="process">Submit</button>

    <pre>

@if($process)
<textarea name="" id="" cols="140" rows="30">
{{ $truncate_query }}

@foreach($process as $query)
{{ $query }}
@endforeach
</textarea>
@endif
    </pre>
</div>
