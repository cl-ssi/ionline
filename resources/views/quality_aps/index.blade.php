@extends('layouts.app')

@section('title', 'Calidad APS')

@section('content')

<h3 class="mb-3">Acreditación de Calidad</h3>

<ul class="fa-ul">
  @foreach($tree as $leaf)
      @if(!isset($depth))
          @php $depth = $leaf['depth'] @endphp
      @endif
      @if($leaf['depth'] > $depth)
          @php $leaf['depth'] > $depth @endphp
          <ul class="fa-ul">
      @endif
      @if($leaf['depth'] < $depth)
          @for($i = $leaf['depth']; $i <$depth ; $i++)
              </ul>
          @endfor
      @endif

      @if($leaf['type'] == 'dir')
        <li>
          <i class="far fa-folder"></i> {{ $leaf['basename'] }}
        </li>
      @else
        @php
            $path = urlencode($leaf['path']);
        @endphp
        @switch($leaf['extension'])
            @case('xls')
                <li><i class="far fa-file-excel"></i><a href="{{ route('quality_aps.download', $path) }}"> {{ $leaf['basename'] }} </a></li>
                @break
            @case('xlsx')
                <li><i class="far fa-file-excel"></i><a href="{{ route('quality_aps.download', $path) }}"> {{ $leaf['basename'] }} </a></li>
                @break
            @case('txt')
                <li><i class="far fa-file"></i><a href="{{ route('quality_aps.download', $path) }}"> {{ $leaf['basename'] }} </a></li>
                @break
            @case('pdf')
                <li><i class="far fa-file-pdf"></i><a href="{{ route('quality_aps.download', $path) }}"> {{ $leaf['basename'] }} </a></li>
                @break
            @case('doc')
                <li><i class="far fa-file-word"></i><a href="{{ route('quality_aps.download', $path) }}"> {{ $leaf['basename'] }} </a></li>
            @break
            @case('docx')
                <li><i class="far fa-file-word"></i><a href="{{ route('quality_aps.download', $path) }}"> {{ $leaf['basename'] }} </a></li>
            @break
            @case('ppt')
                <li><i class="far fa-file-powerpoint"></i><a href="{{ route('quality_aps.download', $path) }}"> {{ $leaf['basename'] }} </a></li>
            @break
            @case('pptx')
                <li><i class="far fa-file-powerpoint"></i><a href="{{ route('quality_aps.download', $path) }}"> {{ $leaf['basename'] }} </a></li>
            @break
            @default
                <li><i class="far fa-file"></i><a href="{{ route('quality_aps.download', $path) }}"> {{ $leaf['basename'] }} </a></li>
        @endswitch
      @endif

      @php $depth = $leaf['depth'] @endphp
  @endforeach
</ul>

@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection
