<div>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"> 
            @if(count($pendingSignaturesFlow->validationMessages) === 0)
                Nro. OTP 
            @else 
                No es posible firmar aún 
            @endif
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" class="form-horizontal"
          action="{{route('signPdfFlow', $pendingSignaturesFlow->id)}}"
          onsubmit="disableButton(this);"
          enctype="multipart/form-data">
        <div class="modal-body">
        @csrf <!-- input hidden contra ataques CSRF -->
            @method('POST')
            <div class="form-row">
                <div class="form-group col-12">
                @if( count($pendingSignaturesFlow->validationMessages) === 0 )
                        @if($pendingSignaturesFlow->signaturesFile->hasOnePendingFlow)
                            @php
                                $allMails = $pendingSignaturesFlow->signature->recipients . ',' . $pendingSignaturesFlow->signature->distribution;
                                preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $allMails, $emails)
                            @endphp
                            <div class="alert alert-info mb-2">Una vez firmado se enviará un correo con el documento a
                                las
                                siguientes direcciones:

                                <ul>
                                    @foreach($emails[0] as $email)
                                        <li> {{$email}} </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

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
            <button type="button" id="cancelSignBtn" class="btn btn-secondary" data-dismiss="modal">Cancelar
            </button>

            @if(count($pendingSignaturesFlow->validationMessages) === 0)
                <button class="btn btn-primary" id="signBtn" type="submit">
                    <i class="fas fa-edit"></i> Firmar
                </button>
            @endif
        </div>
    </form>
</div>
