@extends('layouts.app')

@section('title', 'Planes Comunales')

@section('content')

<h3 class="mb-3">Planes Comunales</h3>

<h6 class="mb-3">
    Comuna:
    @switch($comuna)
        @case('alto_hospicio')
            Alto Hospicio.
            @break
        @case('camina')
            Camiña.
            @break
        @case('colchane')
            Colchane.
            @break
        @case('huara')
            Huara.
            @break
        @case('iquique')
            Iquique.
            @break
        @case('pica')
            Pica.
            @break
        @case('pozo_almonte')
            Pozo Almonte.
            @break
    @endswitch
</h6>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ ($comuna == 'alto_hospicio')?'active':'' }}"
            href="{{ route('health_plan.index', ['alto_hospicio']) }}">
            Alto Hospicio
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ ($comuna == 'camina')?'active':'' }}"
            href="{{ route('health_plan.index', ['camina']) }}">
            Camiña
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ ($comuna == 'colchane')?'active':'' }}"
            href="{{ route('health_plan.index', ['colchane']) }}">
            Colchane
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ ($comuna == 'huara')?'active':'' }}"
            href="{{ route('health_plan.index', ['huara']) }}">
            Huara
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ ($comuna == 'iquique')?'active':'' }}"
            href="{{ route('health_plan.index', ['iquique']) }}">
            Iquique
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ ($comuna == 'pica')?'active':'' }}"
            href="{{ route('health_plan.index', ['pica']) }}">
            Pica
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ ($comuna == 'pozo_almonte')?'active':'' }}"
            href="{{ route('health_plan.index', ['pozo_almonte']) }}">
            Pozo Almonte
        </a>
    </li>

</ul>

<table class="table table-condensed table-hover table-bordered table-sm small">
    <thead>
        <tr>
            <th></th>
            <th>Nombre Archivo</th>
            <th>Tipo</th>
            <th>Descargar</th>
        </tr>
    </thead>

@foreach ($files as $file)
<tr>
    @php
        $url = Storage::url($file);
        $path_download = str_replace("/storage", "", $url);
        $fileName = pathinfo($file)['filename'];
        $type = pathinfo($file)['extension'];
        $fileExt = $fileName.'.'.$type;
    @endphp
    <td>
    </td>
    <td>
      {{ $fileName.'.'.$type }}
    </td>
    <td>
      @switch($type)
          @case('xls')
              <i class="far fa-file-excel fa-2x"></i> Excel
              @break
          @case('xlsx')
              <i class="far fa-file-excel fa-2x"></i> Excel
              @break
          @case('txt')
              <i class="far fa-file fa-2x"></i> Texto
              @break
          @case('pdf')
              <i class="far fa-file-pdf fa-2x"></i> PDF
              @break
          @case('doc')
              <i class="far fa-file-word fa-2x"></i> Word
          @break
          @case('docx')
              <i class="far fa-file-word fa-2x"></i> Word
          @break
          @case('ppt')
              <i class="far fa-file-powerpoint fa-2x"></i> Power Point
          @break
          @case('pptx')
              <i class="far fa-file-powerpoint fa-2x"></i> Power Point
          @break
          @default
              <i class="far fa-file fa-2x"></i> Texto
      @endswitch
    </td>
    <td>
      <a href="{{ route('health_plan.download', [$comuna, $fileExt]) }}" class="btn btn-outline-secondary btn-sm" title="">
                        <span class="fas fa-download" aria-hidden="true"></span></a>
    </td>
</tr>
@endforeach

</table>

@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection
