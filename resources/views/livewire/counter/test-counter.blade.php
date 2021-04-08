
    <div style="text-align: center">
        {{-- If your happiness depends on money, you will never be happy with yourself. Capicci?--}}
        <table class="table table-condensed table-hover table-bordered table-sm small">
          <tbody>
            <tr><td><button wire:click="increment">x++</button></td></tr>
            <tr><td><h1>{{ $count }}</h1></td></tr>
            <tr><td><button wire:click="decrement">x--</button></td></tr>
          </tbody>
        </table>

        <table class="table table-condensed table-hover table-bordered table-sm small">
          <thead>
            <tr>
              <th>Id</th>
              <th>Artículo</th>
              <th>U. de Medida</th>
            </tr>
          </thead>
          <tbody>
            @for($i=0; $i<$count; $i++)
                    <tr>
                        <td>asdf</td>
                        <td>{{$i}}</td>
                        <td>{{$count}}</td>
                    </tr>
            @endfor
          </tbody>
        </table>







    </div>
