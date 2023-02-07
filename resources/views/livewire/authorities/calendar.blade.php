<div>

    <div class="form-row mb-4">
        <div class="col-12 col-md-9">
            <h4>
                {{ $organizationalUnit->name }}
            </h4>
        </div>
        <div class="col-6 col-md-3">
            <input class="form-control" type="month" wire:model="monthSelection">
        </div>
    </div>

    @if($editForm)
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Editar autoridad para la fecha {{ $date }}</h5>
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="">Usuario</label>
                        <select name="" id="" class="form-control">
                            <option value="">Alvaro Torres</option>
                            <option value="">Esteban Miranda</option>
                            <option value="">Alvaro Lupa</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Desde</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-primary form-control" wire:click="save()">
                            <i class="fas fa-save"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <h5 clas="mb-3">
        {{ ucfirst($startOfMonth->monthName) }} de {{ $startOfMonth->year }}
    </h5>

    @for($i = 1; $i < $startOfMonth->dayOfWeek; $i++)
    <div class="dia_calendario small p-2 text-center">
        <br><br><br><br><br><br>
    </div>
    @endfor

    @foreach($data as $date => $authority)
        <div class="dia_calendario small p-2 text-center {{ ($today == $date) ? 'border-primary' : '' }}">

            <span class="{{ ($authority['holliday'] OR $authority['date']->dayOfWeek == 0) ? 'text-danger': '' }}">
                {{ $date }} 
            </span>

            <hr class="mt-1 mb-1">
                <a href="#" class="link-primary" 
                    wire:click="edit('{{ $date }}','manager')">
                    {{ optional($authority['manager'])->tinnyName }}
                </a>
             <br>
            <em class="text-muted">{{ optional($authority['manager'])->position }}</em>
            
            <hr class="mt-1 mb-1" >
            {{ optional($authority['secretary'])->tinnyName }} <br>
            <em class="text-muted">{{ optional($authority['secretary'])->position }}</em>

        </div>
    @endforeach

    @section('custom_css')
    <style media="screen">
        .dia_calendario {
            display: inline-block;
            border: solid 1px rgb(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            width: 13.9%;
            /* width: 154px; */
            text-align: center;
            margin-bottom: 5px;
        }
    </style>
    @endsection
</div>
