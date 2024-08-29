@extends('layouts.bt4.app')
@section('title', 'Formulario de requerimiento')
@section('content')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
    {{--    <h4 class="mb-3">Compra</h4>--}}

    <form method="POST" action="{{ route('request_forms.items.update', $itemRequestForm->id)}}">
        @csrf
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-cart-plus"></i>Editar Item {{$itemRequestForm->id}}</h5>
                <div class="form-row">
                    <fieldset class="form-group col-sm-5">
                        <label for="forArticle">Artículo:</label>
                        <input name="article" id="forArticle" class="form-control form-control-sm" type="text"
                               value="{{$itemRequestForm->article}}">
                    </fieldset>

                    <fieldset class="form-group col-sm-3">
                        <label for="for_unit_of_measurement">Unidad de Medida:</label><br>
                        <select name="unit_of_measurement" id="for_unit_of_measurement"
                                class="form-control form-control-sm" required>
                            <option value="">Seleccione...</option>
                            @foreach($unitsOfMeasurement as $unitOfMeasurement)
                                <option
                                    value="{{$unitOfMeasurement->name}}" {{$unitOfMeasurement->name === $itemRequestForm->unit_of_measurement ? 'selected' : ''}} >{{$unitOfMeasurement->name}}</option>
                            @endforeach
                        </select>
                    </fieldset>

                    <fieldset class="form-group col-sm-2">
                        <label for="for_quantity">Cantidad:</label>
                        <input name="quantity" id="for_quantity" class="form-control form-control-sm" type="text"
                               value="{{$itemRequestForm->quantity}}">
                    </fieldset>

                    <fieldset class="form-group col-sm-2">
                        <label for="for_unit_value">Valor Unitario Neto:</label>
                        <input name="unit_value" id="for_unit_value" class="form-control form-control-sm"
                               type="text" value="{{$itemRequestForm->unit_value}}">
                    </fieldset>
                </div>
                <div class="form-row">
                    <fieldset class="form-group col-sm-5">
                        <label for="for_technical_specifications" class="form-label">Especificaciones
                            Técnicas:</label>
                        <textarea name="technical_specifications" id="for_technical_specifications"
                                  class="form-control form-control-sm"
                                  rows="2">{!! $itemRequestForm->specification !!}</textarea>
                    </fieldset>
                    <fieldset class="form-group col-sm-3">
                        <label for="for_taxes">Tipo de Impuestos:</label><br>
                        <select name="taxes" id="for_taxes" class="form-control form-control-sm" required>
                            <option value="">Seleccione...</option>
                            <option value="iva" {{$itemRequestForm->tax == 'iva' ? 'selected' : ''}}>I.V.A. 19%
                            </option>
                            <option value="bh" {{$itemRequestForm->tax == 'bh' ? 'selected' : ''}} >Boleta de
                                Honorarios
                            </option>
                            {{--                        <option value="bh">Boleta de Honorarios {{isset($this->withholding_tax[date('Y')]) ? $this->withholding_tax[date('Y')] * 100 : end($this->withholding_tax) * 100 }}%</option>--}}
                            <option value="srf" {{$itemRequestForm->tax == 'srf' ? 'selected' : '' }} >S.R.F Zona
                                Franca 0%
                            </option>
                            <option value="e" {{$itemRequestForm->tax == 'e' ? 'selected' : ''}}>Exento 0%</option>
                            <option value="nd" {{$itemRequestForm->tax == 'nd' ? 'selected' : '' }}>No Definido
                            </option>
                        </select>
                    </fieldset>
                    <fieldset class="form-group col-sm-4">
                        <label class="form-label" for="for_article_file">Documento Informativo (optativo):
                            {{--                        @if($savedArticleFile)--}}
                            {{--                            <a class="text-info" href="#items" wire:click="deleteFile({{$key}})">Borrar <i class="fas fa-paperclip"></i></a>--}}
                            {{--                        @endif--}}
                        </label>
                        {{--                    <input class="form-control form-control-sm" type="file" style="padding:2px 0px 0px 2px;" wire:model="articleFile" name="articleFile" id="upload{{ $iteration }}" @if($savedArticleFile) disabled @endif>--}}
                    </fieldset>
                    <fieldset>
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </fieldset>
                </div>
            </div>
        </div>
        </div>
    </form>
@endsection
