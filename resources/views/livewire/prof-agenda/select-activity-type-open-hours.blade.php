<div class="row">

    <fieldset class="form-group col col-md">
        <label for="for_activity_type_id">T.actividad</label>
        <select name="activity_type_id" class="form-control" id="" required>
            <option value=""></option>
            @foreach($activityTypes as $activityType)
                <option value="{{$activityType->id}}">{{$activityType->name}}</option>
            @endforeach
        </select>
    </fieldset>

    <fieldset class="form-group col col-md">
        <label for="for_duration">Hora</label>
        <select name="duration" name="duration" class="form-control" id="" required>
            <option value=""></option>
            <option value="60">60</option>
            <option value="40">40</option>
            <option value="30">30</option>
            <option value="20">20</option>
        </select>
    </fieldset>

</div>
