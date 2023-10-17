@extends('layouts.bt4.app')

@section('title', 'Creación de Staff por Unidad Organizacional')

@section('content')

@include('replacement_staff.nav')

<br>

<h5><i class="fas fa-cog fa-fw"></i>Creación de Staff por Unidad Organizacional</h5>

<br>

<form method="POST" class="form-horizontal" action="{{ route('replacement_staff.staff_manage.store') }}" enctype="multipart/form-data">
    @csrf
    @method('POST')

    @livewire('replacement-staff.search-select-replacement-staff')

    <hr>

    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_ou_of_performance_id">Unidad Organizacional</label>
            <select class="form-control selectpicker" data-live-search="true" id="for_ou_of_performance_id" name="ou_of_performance_id" data-size="5" required>
                @foreach($ouRoots as $ouRoot)
                  <option value="{{ $ouRoot->id }}" {{-- ($user->organizationalunit == $ouRoot)?'selected':''--}}>
                  {{ $ouRoot->name }} ({{$ouRoot->establishment->name}})
                  </option>
                  @foreach($ouRoot->childs as $child_level_1)
                    <option value="{{ $child_level_1->id }}" {{-- ($user->organizationalunit == $child_level_1)?'selected':'' --}}>
                    &nbsp;&nbsp;&nbsp;
                    {{ $child_level_1->name }} ({{ $child_level_1->establishment->name }})
                    </option>
                    @foreach($child_level_1->childs as $child_level_2)
                      <option value="{{ $child_level_2->id }}" {{-- ($user->organizationalunit == $child_level_2)?'selected':'' --}}>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      {{ $child_level_2->name }} ({{ $child_level_2->establishment->name }})
                      </option>
                      @foreach($child_level_2->childs as $child_level_3)
                        <option value="{{ $child_level_3->id }}" {{-- ($user->organizationalunit == $child_level_3)?'selected':'' --}}>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          {{ $child_level_3->name }} ({{ $child_level_3->establishment->name }})
                        </option>
                        @foreach($child_level_3->childs as $child_level_4)
                        <option value="{{ $child_level_4->id }}" {{-- ($user->organizationalunit == $child_level_4)?'selected':'' --}}>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $child_level_4->name }} ({{ $child_level_4->establishment->name }})
                                    </option>
                        @endforeach
                      @endforeach
                    @endforeach
                  @endforeach
                @endforeach
            </select>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary float-right" id="save_btn"><i class="fas fa-save"></i> Guardar</button>

</form>

<br><br><br>

@endsection

@section('custom_js')

<script type="text/javascript">

document.getElementById("save_btn").disabled = true;

function myFunction() {
  // Get the checkbox
  var checkBox = document.getElementById("for_applicant_id");

  // If the checkbox is checked, display the output text
  if (document.querySelectorAll('input[type="checkbox"]:checked').length > 0){
    document.getElementById("save_btn").disabled = false;
  } else {
    document.getElementById("save_btn").disabled = true;
  }
}
</script>

@endsection
