<span>
    @if($msg)
      <div class="alert alert-info" role="alert">
        {{$msg}}
      </div>
    @endif

    @if($parametroMes != null)
      {{$array_valores_mensualizados[$parametroMes]}}
    @else
      @if($resultadoEnNumero)
          @php $total = 0;
              $cont = 1;
          @endphp
          @foreach($valores as $key => $valor)
              {{"Cuota: ".$cont." - Mes: ".$key.": $".number_format($valor, 0, ',', '.')}} <br>
              @php
                  $total = $total + $valor;
                  $cont++;
              @endphp
          @endforeach
          <strong> Total: </strong>{{number_format($total, 0, ',', '.')}}
      @else
          {{ $valores }}
      @endif
    @endif
</span>
