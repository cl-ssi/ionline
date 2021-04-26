<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"> @if(count($pendingSignaturesFlow->validationMessages) === 0)
                Nro. OTP @else No es posible firmar aún @endif</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" class="form-horizontal"
          action="{{route('signPdfFlow', $pendingSignaturesFlow->id)}}"
          enctype="multipart/form-data">
        <div class="modal-body">
        @csrf <!-- input hidden contra ataques CSRF -->
            @method('POST')
            <div class="form-row">
                <div class="form-group col-12">
                    @if( count($pendingSignaturesFlow->validationMessages) === 0 )
                        <label for="forotp">Ingrese número OTP.</label>
                        <input type="text" class="form-control form-control-sm" id="forotp"
                               name="otp" maxlength="6" autocomplete="off" required/>
                    @else
                        <ul class="list-group">
                            @foreach($pendingSignaturesFlow->validationMessages as $validationMessage)
                                <li class="list-group-item list-group-item-warning">
                                    {{$validationMessage}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
            </button>

            @if(count($pendingSignaturesFlow->validationMessages) === 0)
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-edit"></i> Firmar
                </button>
            @endif
        </div>
    </form>
</div>
