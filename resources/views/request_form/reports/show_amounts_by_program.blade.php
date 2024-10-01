@extends('layouts.bt4.app')

@section('title', 'Reportes')

@section('content')

@include('request_form.partials.nav')

<div class="row">
  <div class="col-sm">
      <h5 class="mb-3">Reporte:</h5>
      <h6 class="mb-3"><i class="fas fa-fw fa-list-ol"></i>Formularios - Montos por programa</h6>
  </div>
</div>

<!-- </div>

<div class="col-sm"> -->
    @livewire('request-form.search-program-amounts', [
      'inbox' => 'report: form-program-amounts'
    ])
<!-- </div> -->

@endsection

@section('custom_js')

<script type="text/javascript">
    $(document).ready(function() {
        $('.popover-item').popover({
            html: true,
            trigger: 'hover',
            content: function() {
                return $(this).next('.popover-list-content').html();
            }
        });
    });

    document.addEventListener('livewire:update', function() {
        $('.selectpicker').selectpicker('refresh');
    });
</script>

@endsection