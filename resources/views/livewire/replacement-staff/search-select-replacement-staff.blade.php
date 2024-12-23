<div>
    <div class="card card-body">
        <div class="form-row">
            <fieldset class="form-group col-5">
                <label for="for_name">Nombres / Identificación</label>
                <input class="form-control" type="text" name="search" autocomplete="off" style="text-transform: uppercase;"
                  placeholder="RUN (sin dígito verificador) / NOMBRE" wire:model.live="selectedSearch">
            </fieldset>

            <fieldset class="form-group col-2">
                <label for="for_profile_search">Estamento</label>
                <select name="profile_search" class="form-control" wire:model.live="selectedProfile">
                    <option value="0">Seleccione...</option>
                    @foreach($profileManage as $profile)
                        <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="form-group col-5">
                <label for="for_profession_search">Profesión</label>
                <select name="profession_search" class="form-control" wire:model.live="selectedProfession">
                    <option value="0">Seleccione...</option>
                    @if(!is_null($professionManage))
                    @foreach($professionManage as $profession)
                        <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                    @endforeach
                    @endif
                </select>
            </fieldset>
        </div>
    </div>

    <br>

    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center small">
                <tr>
                    <th style="width: 20%">Nombre Completo</th>
                    <th style="width: 10%">Run</th>
                    <th>Estamento</th>
                    <th>Título</th>
                    <th>Fecha Titulación</th>
                    <th>Años Exp.</th>
                    <th>Estado</th>
                    <th style="width: 15%"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($replacementStaff as $staff)
                <tr>
                    <td>{{ $staff->fullName }}</td>
                    <td>{{ $staff->Identifier }}</td>
                    <td>
                        @foreach($staff->profiles as $title)
                            <h6><span class="badge rounded-pill bg-light">{{ $title->profile_manage->name }}</span></h6>
                        @endforeach
                    </td>
                    <td>
                        @foreach($staff->profiles as $title)
                            <h6><span class="badge rounded-pill bg-light">{{ ($title->profession_manage) ? $title->profession_manage->name : '' }}</span></h6>
                        @endforeach
                    </td>
                    <td>
                        @foreach($staff->profiles as $title)
                            <h6><span class="badge rounded-pill bg-light">{{ Carbon\Carbon::parse($title->degree_date)->format('d-m-Y') }}</span></h6>
                        @endforeach
                    </td>
                    <td>
                        @foreach($staff->profiles as $title)
                            <h6><span class="badge rounded-pill bg-light">{{ $title->YearsOfDegree }}</span></h6>
                        @endforeach
                    </td>
                    <td>{{ $staff->StatusValue }}</td>
                    <td>
                        <a href="{{ route('replacement_staff.show_replacement_staff', $staff) }}"
                          class="btn btn-outline-secondary btn-sm"
                          title="Ir"
                          target="_blank"> <i class="far fa-eye"></i></a>
                        <a href="{{ route('replacement_staff.show_file', $staff) }}"
                          class="btn btn-outline-secondary btn-sm"
                          title="Ir"
                          target="_blank"> <i class="far fa-file-pdf"></i></a>
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="replacement_staff_id[]"
                                    value="{{ $staff->id }}" onclick="myFunction()" id="for_applicant_id">
                            </div>
                        </fieldset>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
