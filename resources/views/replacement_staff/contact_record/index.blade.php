@extends('layouts.bt4.app')

@section('title', 'Creación de Staff por Unidad Organizacional')

@section('content')

@include('replacement_staff.nav')

<br>

<div class="row">
    <div class="col-sm-4">
        <h5><i class="fas fa-address-book"></i> Registro de Contacto Teléfonico.</h5>
        <h6><i class="fas fa-user"></i> {{ $staff->fullName }}</h6>
    </div>
    <div class="col-sm">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i> Nuevo Registro
        </button>

        @include('replacement_staff.contact_record.modals.create')
    </div>
</div>

<br>

<div class="row">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead class="text-center small">
                    <tr>
                        <th style="width: 8%">Fecha</th>
                        <th>Postulante</th>
                        <th>Tipo</th>
                        <th style="width: 40%">Observación</th>
                        <th>Usuario de Registro</th>
                        <th style="width: 2%"></th>
                    </tr>
                </thead>
                <tbody class="small">
                  @foreach($contactRecords as $contactRecord)
                    <tr>
                        <td>{{ $contactRecord->contact_date->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $contactRecord->replacementStaff->fullName }}</td>
                        <td class="text-center">
                          @switch($contactRecord->type)
                              @case('email')
                                  <i class="fas fa-at fa-lg"></i> <i class="fas fa-envelope fa-lg"></i>
                                  @break

                              @case('telephone')
                                  <i class="fas fa-phone fa-lg"></i>
                                  @break

                              @case('other')
                                  Otro Contacto
                                  @break
                          @endswitch
                        </td>
                        <td>{{ $contactRecord->observation }}</td>
                        <td>{{ $contactRecord->user->fullName }}</td>
                        <td>
                            <a href=""
                              class="btn btn-outline-secondary btn-sm disabled"
                              title="Ir"> <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<br>

@endsection

@section('custom_js')

@endsection
