<div>
    <div class="card card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm">
                <label for="for_name">Nombres / Identificación</label>
                <input class="form-control" type="text" name="search" autocomplete="off" style="text-transform: uppercase;"
                  placeholder="RUN (sin dígito verificador) / NOMBRE" wire:model.live.debounce.500ms="selectedSearch">
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="for_profile_search">Estamento</label>
                <select name="profile_search" class="form-control" wire:model.live.debounce.500ms="selectedProfile">
                    <option value="0">Seleccione...</option>
                    @foreach($profileManage as $profile)
                        <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="for_profession_search">Profesión</label>
                <select name="profession_search" class="form-control" wire:model.live.debounce.500ms="selectedProfession">
                    <option value="0">Seleccione...</option>
                    @if(!is_null($professionManage))
                    @foreach($professionManage as $profession)
                        <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                    @endforeach
                    @endif
                </select>
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="for_staff_search">Staff de Unidad Organizacional</label>
                <select name="staff_search" class="form-control" wire:model.live.debounce.500ms="selectedStaff">
                    <option value="0">Seleccione...</option>
                    @foreach(App\Models\ReplacementStaff\StaffManage::getStaffByOu() as $staff)
                        <option value="{{ $staff->organizationalUnit->id }}">{{ $staff->organizationalUnit->name }}</option>
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="for_status_search">Estado</label>
                <select name="status_search" class="form-control" wire:model.live.debounce.500ms="selectedStatus">
                    <option value="0">Seleccione...</option>
                    <option value="immediate_availability">Disponibilidad Inmediata</option>
                    <option value="working_external">Trabajando</option>
                    <option value="selected">Seleccionado</option>
                </select>
            </fieldset>
        </div>

        <div class="form-row">
            <div class="col">
                <a class="btn btn-primary float-right" wire:click="clearForm()">
                    <i class="fas fa-eraser"></i> Limpiar Búsqueda
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p class="font-weight-lighter">Total de Registros: <b>{{ $replacementStaff->total() }}</b></p>
        </div>
    </div>

    <br>

    <div class="table-responsive">
        {{ $replacementStaff->links() }}
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center small">
                <tr>
                    <th>Ingreso Antecedentes</th>
                    <th>Nombre Completo</th>
                    <th>Run</th>
                    <th>Estamento</th>
                    <th>Título</th>
                    <th>Experiencia</th>
                    <th>Fecha Titulación</th>
                    <th>Años Exp.</th>
                    <th>Estado</th>
                    <!-- <th>Periodo Efectivo</th> -->
                    <th style="width: 8%">Más...</th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($replacementStaff as $staff)
                <tr>
                    <td>{{ $staff->created_at->format('d-m-Y H:i:s') }}</td>
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
                            <h6><span class="badge rounded-pill bg-light">{{ $title->ExperienceValue }}</span></h6>
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($staff->profiles as $title)
                            <h6><span class="badge rounded-pill bg-light">
                                {{ ($title->degree_date) ? $title->degree_date->format('d-m-Y') : ''}}
                            </span></h6>
                        @endforeach
                    </td>
                    <td class="text-center">
                        @foreach($staff->profiles as $title)
                            <h6><span class="badge rounded-pill bg-light">{{ $title->YearsOfDegree }}</span></h6>
                        @endforeach
                    </td>
                    <td>{{ $staff->StatusValue }}</td>
                    <!-- <td>{{-- $staff->applicants->first()->start_date->format('d-m-Y') --}}</td> -->
                    <td>
                        <a href="{{ route('replacement_staff.show_replacement_staff', $staff) }}"
                            class="btn btn-outline-secondary btn-sm"
                            title="Ver Detalle"> <i class="far fa-eye"></i></a>
                        <a href="{{ route('replacement_staff.view_file', $staff) }}"
                            class="btn btn-outline-secondary btn-sm"
                            title="Curriculum Vitae"
                            target="_blank"> <i class="far fa-file-pdf"></i></a>
                        <a href="{{ route('replacement_staff.contact_record.index', $staff) }}"
                            class="btn btn-outline-secondary btn-sm"
                            title="Registro de Contacto"> <i class="fas fa-address-book"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $replacementStaff->links() }}
    </div>
</div>
