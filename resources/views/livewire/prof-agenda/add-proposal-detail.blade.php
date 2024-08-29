<div>
    
    <div class="row">

        <fieldset class="form-group col col-md">
            <label for="for_id_deis">Día</label>
            <select class="form-control" name="day" wire:model.live="day" required>
                <option value=""></option>
                <option value="1">Lunes</option>
                <option value="2">Martes</option>
                <option value="3">Miercoles</option>
                <option value="4">Jueves</option>
                <option value="5">Viernes</option>
                <option value="6">Sábado</option>
                <option value="7">Domingo</option>
            </select>
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_id_deis">Hora de inicio</label>
            <input type="time" class="form-control" name="start_hour" wire:model.live="start_hour" value="" step="3600000" required>
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_id_deis">Hora de término</label>
            <input type="time" class="form-control" name="end_hour" wire:model.live="end_hour" value="" step="3600000" required>
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_duration">Duración</label>
            <select name="duration" wire:model.live="duration" class="form-control" id="" required>
                <option value=""></option>
                <option value="60">60</option>
                <option value="40">40</option>
                <option value="30">30</option>
                <option value="20">20</option>
            </select>
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_activity_type_id">Tipo de actividad</label>
            <select name="activity_type_id" wire:model.live="activity_type_id" class="form-control" id="" required>
                <option value=""></option>
                @foreach($activity_types as $activity_type)
                    <option value="{{$activity_type->id}}">{{$activity_type->name}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col col-md-2">
            <label for="for_id_deis"><br></label>
            <button type="submit" class="btn btn-primary form-control" @disabled($proposal->status == "Aperturado") wire:click="save()">Guardar</button>
        </fieldset>
    
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    
    @if($proposal->details->count()>0)

        <table class="table table-striped table-sm table-bordered">
            <thead>
                <tr>
                    <th nowrap>Día</th>
                    <th nowrap>H.Inicio</th>
                    <th nowrap>H.Término</th>
                    <th nowrap>Duración</th>
                    <th nowrap>Tipo de actividad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($proposal->details as $detail)
                <tr>
                    <td nowrap>{{ $detail->getDayAttribbute() }}</td>
                    <td nowrap>{{ $detail->start_hour }}</td>
                    <td nowrap>{{ $detail->end_hour }}</td>
                    <td nowrap>{{ $detail->duration }}</td>
                    <td nowrap>@if($detail->activityType){{ $detail->activityType->name }}@endif</td>
                    <td width="10%">
                        <button type="submit" class="btn btn-outline-danger btn-sm" wire:click="delete({{$detail}})"
                            @disabled($proposal->status == "Aperturado")
                            onclick="return confirm('¿Está seguro que desea eliminar el detalle?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
    
</div>
