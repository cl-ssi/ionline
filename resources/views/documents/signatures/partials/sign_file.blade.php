<div class="modal fade" id="signPdfModal{{$idSignModal}}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Firmar documento {{$idSignModal}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" class="form-horizontal"
                  action="{{route('signPdf')}}"
                  enctype="multipart/form-data">
                <div class="modal-body">
                @csrf <!-- input hidden contra ataques CSRF -->
                    @method('POST')
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="forotp">Ingrese número OTP.</label>
                            <input type="text" class="form-control form-control-sm" id="forotp"
                                   name="otp" maxlength="6" autocomplete="off" required/>
{{--                            <input type="hidden" name="file_path" value="modulo1/1.pdf">--}}
                            <input type="hidden" name="route" value={{$routePdfSignModal}}>
                            <input type="hidden" name="return_url" value={{$returnUrlSignModal}}>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                    </button>

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-edit"></i> Firmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{--<div class="modal fade" id="signPdfModal{{$signedSignaturesFlow->id}}" tabindex="-1" role="dialog"--}}
{{--     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="exampleModalLongTitle">Modal incrustado {{$signedSignaturesFlow->id}} </h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <form method="POST" class="form-horizontal"--}}
{{--                  action="{{route('signPdf')}}"--}}
{{--                  enctype="multipart/form-data">--}}
{{--                <div class="modal-body">--}}
{{--                @csrf <!-- input hidden contra ataques CSRF -->--}}
{{--                    @method('POST')--}}
{{--                    <div class="form-row">--}}
{{--                        <div class="form-group col-12">--}}
{{--                            <label for="forotp">Ingrese número OTP.</label>--}}
{{--                            <input type="text" class="form-control form-control-sm" id="forotp"--}}
{{--                                   name="otp" maxlength="6" autocomplete="off" required/>--}}
{{--                            --}}{{--                            <input type="hidden" name="file_path" value="modulo1/1.pdf">--}}
{{--                            <input type="hidden" name="route" value="/rrhh/service_requests/resolution-pdf/2">--}}
{{--                            <input type="hidden" name="return_url" value="documents.callbackFirma">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar--}}
{{--                    </button>--}}

{{--                    <button class="btn btn-primary" type="submit">--}}
{{--                        <i class="fas fa-edit"></i> Firmar--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
