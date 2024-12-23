<form action="{{ route('requirements.archive_mass') }}" method="POST">
    @csrf
    <button type="submit" id="archiveMassBtn" class="btn btn-primary btn-sm" disabled>
        <i class="fas fa-archive"></i> Archivar seleccionados
    </button>    
    <br>
    <table class="table table-sm table-bordered small" id="tabla_requerimientos">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="selectAll">
                </th>
                <th>N°</th>
                <th>Asunto</th>
                <th width="160">Creado</th>
                <th width="160">Ultimo evento</th>
                <th width="100">Fecha límite</th>
                <td width="106"></td>
            </tr>
        </thead>
        <tbody>
            @foreach($requirements as $req)

                <tr>
                @switch($req->status)
                    @case('creado')
                        <tr class="alert-light"> @break
                    @case('respondido') 
                        <tr class="alert-warning"> @break
                    @case('cerrado') 
                        <tr class="alert-success"> @break
                    @case('derivado') 
                        <tr class="alert-primary"> @break
                    @case('reabierto') 
                        <tr class="alert-light"> @break
                @endswitch
                
                @php
                $copia = ($req->user_id != $user->id AND $req->events->where('to_user_id',$user->id)->count() == $req->ccEvents->where('to_user_id',$user->id)->count()) ? 'alert-secondary':'';
                @endphp
                    <td class="checkbox-column">
                        <input type="checkbox" name="archive[]" value="{{ $req->id }}" class="archive-checkbox">
                    </td>

                    <td class="{{ $copia }} text-center">
                        {{ $req->id }}
                    </td>

                    <td class="{{ $copia }}">
                        {{ $req->subject }}
                        <br>
                        @foreach($req->labels->where('user_id', auth()->id()) as $label)
                            <span class='badge badge-pill badge-primary' style='background-color: #{{$label->color}};'>
                                <i class="fas fa-tag"></i> {{$label->name}}
                            </span>
                        @endforeach

                        @if($req->parte)
                            <div>
                                <small>
                                    Parte: <b>{{ $req->parte->origin}} - {{$req->parte->number}}</b>
                                </small>
                            </div>
                        @endif

                        @if($req->category_id)
                        <span class='badge badge-dark'>
                            <i class="fas fa-copyright"></i> {{ optional($req->category)->name }}
                        </span>
                        @endif
                    </td>

                    <td class="{{ $copia }}">
                        <b>Creado por</b><br>
                        {{ $req->events->first()->from_user->tinyName }}<br>
                        {{ $req->created_at->format('Y-m-d H:i') }}<br>
                        {{ $req->created_at->diffForHumans() }}<br>
                    </td>

                    <td>
                    @switch($req->status)
                        @case('creado')
                        @break

                        @case('cerrado')
                        <b>Cerrado por</b><br>
                        {{ $req->events->last()->from_user->tinyName }}<br>
                        {{ $req->events->last()->created_at->format('Y-m-d H:i') }}<br>
                        @break

                        @case('respondido')
                        @case('reabierto')
                        <b>{{ ucfirst($req->status) }} por</b><br>
                        {{ $req->events->last()->from_user->tinyName }}<br>
                        {{ $req->events->last()->created_at->format('Y-m-d H:i') }}<br>
                        <b>para </b>{{ $req->events->last()->to_user->tinyName }}
                        @break


                        @case('derivado')
                        <b>{{ ucfirst($req->status) }} para</b><br>
                        {{ $req->events->last()->to_user->tinyName }}<br>
                        {{ $req->events->last()->created_at->format('Y-m-d H:i') }}<br>
                        <b>de </b>{{ $req->events->last()->from_user->tinyName }}
                        @break
                    @endswitch
                    
                    
                    </td>

                    <td class="{{ $copia }}">
                        @if($req->limit_at)
                        
                            <div class="text-danger">
                                <i class="fas fa-fw fa-chess-king"></i>
                                {{ $req->limit_at->format('Y-m-d') }}
                            </div>

                            @if($req->events->whereNotNull('limit_at')->where('status','!=','en copia')->count() >= 1)
                                @foreach($req->events->whereNotNull('limit_at')->where('status','!=','en copia') as $event)

                                    <div class="{{ now() >= $event->limit_at ? 'text-danger':'' }}">
                                        <i class="fas fa-fw fa-chess-pawn"></i>
                                        {{ $event->limit_at->format('Y-m-d') }}
                                    </div>

                                @endforeach
                            @endif

                        @endif

                    </td>

                    <td class="{{ $copia }}">
                        @if($req->archived->where('user_id',auth()->id())->isEmpty())
                        <a href="{{ route('requirements.archive_requirement',$req) }}" title="Archivar" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-fw fa-box-open"></i>
                        </a>
                        @else
                        <a href="{{ route('requirements.archive_requirement_delete',$req) }}" title="Desarchivar" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-fw fa-box"></i>
                        </a>
                        @endif
                        
                        <a href="{{ route('requirements.show',$req->id) }}" class="btn btn-sm float-right {{ $req->unreadedEvents ? 'btn-success':'btn-outline-primary' }}">
                            @if($req->unreadedEvents)
                            <i class="fas fa-fw fa-envelope"></i> <span class='badge badge-secondary'>{{ $req->unreadedEvents }}</span>
                            @else
                            <i class="fas fa-fw fa-edit"></i>
                            @endif
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</form>


@section('custom_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    let date = new Date()
    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()
    let hour = date.getHours()
    let minute = date.getMinutes()

    function exportF(elem) {
        var table = document.getElementById("tabla_requerimientos");
        var html = table.outerHTML;
        var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
        var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "tabla_requerimientos_inbox_" + day + "_" + month + "_" + year + "_" + hour + "_" + minute + ".xls"); // Choose the file name
        return false;
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#selectAll").click(function () {
            $(".checkbox-column input[type='checkbox']").prop('checked', $(this).prop('checked'));
        });
    });
</script>

<script>
$(document).ready(function() {
    // Detecta cuando cualquier checkbox es seleccionado o deseleccionado
    $('.archive-checkbox').change(function() {
        // Verifica si al menos un checkbox está seleccionado
        var anyChecked = $('.archive-checkbox:checked').length > 0;
        // Habilita o deshabilita el botón basado en si hay checkboxes seleccionados
        $('#archiveMassBtn').prop('disabled', !anyChecked);

        console.log('Cambio en checkboxes detectado.');
    });

    // Opcional: Manejo del checkbox "Seleccionar todos"
    $('#selectAll').click(function() {
        $('.archive-checkbox').prop('checked', this.checked).change();
    });
});

</script>

@endsection
