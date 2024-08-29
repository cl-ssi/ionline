<div class="row">

    <fieldset class="form-group col col-md">
        <label for="for_activity_type_id">T.actividad (*)</label>
        <select name="activity_type_id" wire:model.live="activity_type_id" class="form-control" id="" required>
            <option value=""></option>
            @foreach($activityTypes as $activityType)
                <option value="{{$activityType->id}}">{{$activityType->name}}</option>
            @endforeach
        </select>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_open_hour_id">Hora (*)</label>
        <select name="open_hour_id" class="form-control" id="" required>
            <option value=""></option>
            @foreach($openHours as $openhour)
                <option value="{{$openhour->id}}">{{$openhour->start_date->format('Y-m-d H:i')}} - {{$openhour->end_date->format('Y-m-d H:i')}}</option>
            @endforeach
        </select>
    </fieldset>

</div>
