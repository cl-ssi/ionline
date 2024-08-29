<fieldset class="form-group col-sm-6">
    <label for="regiones">Año / Establecimiento *</label>
    <!-- <div wire:ignore id="for-bootstrap-select"> -->
      <div class="input-group">
        <!-- <div wire:ignore id="for-bootstrap-select"> -->
          <select class="form-control selectpicker show-tick" id="for_year_id" name="year" wire:model.live="selectedYear" required>
              <option value="">Selección...</option>
              <option value="2024">2024</option>
              <option value="2023">2023</option>
              <option value="2022">2022</option>
              <option value="2021">2021</option>
              <option value="2020">2020</option>
          </select>
        <!-- </div> -->

        <!-- <div id="for-picker" wire:ignore> -->
          <!--  -->
            <select class="form-control selectpicker" id="for_establishment_id" name="establishment_id[]" data-live-search="true" data-actions-box="true" multiple wire:model="selectedEstablishment" required>
                {{-- @foreach($establishments as $estab)
                  <option value="{{ $estab->Codigo }}">{{ $estab->alias_estab }}</option>
                @endforeach --}}

                @php($temp = null)
                @foreach($establishments as $estab)
                    @if($estab->comuna != $temp) <optgroup label="{{$estab->comuna}}"> @endif
                    <option value="{{ $estab->Codigo }}" @if (isset($establecimiento) && in_array($estab->Codigo, $establecimiento)) selected @endif>{{ $estab->alias_estab }}</option>
                    @php($temp = $estab->comuna)
                    @if($estab->comuna != $temp) </optgroup> @endif
                @endforeach
            </select>
          <!--  -->
        <!-- </div> -->
      </div>
    <!--  -->
</fieldset>

@section('custom_js')
<script>

document.addEventListener("DOMContentLoaded", () => {
    Livewire.hook('message.received', (message, component) => {
        $('select').selectpicker('destroy');
    })
});

window.addEventListener('contentChanged', event => {
    $('select').selectpicker();
});

</script>
@endsection
