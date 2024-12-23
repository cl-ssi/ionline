<div>
    <div class="modal-header">
        @php
            $modalTitleText = '';
            $hasValidationMessages = false;
        @endphp

        @foreach ($pendingSignaturesFlows as $pendingSignaturesFlow)
            @if(count($pendingSignaturesFlow->validationMessages) != 0)
                @php
                    $modalTitleText .= "No es posible aún firmar solicitudes" ;
                    $hasValidationMessages = true;
                @endphp
                @break; 
            @endif
        @endforeach

        @if(!$hasValidationMessages)
            @php
                $modalTitleText = 'Nro. OPT';
            @endphp
        @endif

        <h5 class="modal-title" id="exampleModalLongTitle"> 
                {{$modalTitleText}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="POST" class="form-horizontal"
          action="{{route('signPdfFlow', 1)}}"
          onsubmit="disableButton(this);"
          enctype="multipart/form-data">

        <input type="hidden"
        name="pendingSignaturesFlowsIds"
        value="{{ json_encode($pendingSignaturesFlows->pluck('id')) }}"
        >

        <div class="modal-body">
        @csrf <!-- input hidden contra ataques CSRF -->
            @method('POST')
            <div class="form-row">
                <div class="form-group col-12">
                    @if(!$hasValidationMessages)
                        @foreach($pendingSignaturesFlows as $pendingSignaturesFlow)
                            @if($pendingSignaturesFlow->signaturesFile->hasOnePendingFlow)
                                @php
                                    $allMails = $pendingSignaturesFlow->signature->recipients . ',' . $pendingSignaturesFlow->signature->distribution;
                                    preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $allMails, $emails)
                                @endphp
                                <div class="alert alert-info mb-2">"Una vez firmada la solicitud {{$pendingSignaturesFlow->signature->id}} se enviará un correo con el documento a
                                    las
                                    siguientes direcciones:"
                                    <ul>
                                        @foreach($emails[0] as $email)
                                            <li> {{$email}} </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach

                        <label for="forotp">Ingrese número OTP.</label>
                        <input type="text" class="form-control form-control-sm" id="forotp"
                                name="otp" maxlength="6" autocomplete="off" required/>
                    @else
                        <ul class="list-group">
                            @foreach($pendingSignaturesFlows as $pendingSignaturesFlow)
                                @if(count($pendingSignaturesFlow->validationMessages) > 0)
                                    <li class="list-group-item list-group-item-primary">
                                        {{'Solicitud: ' . $pendingSignaturesFlow->signature->id . ':'}}
                                    </li>
                                    @foreach($pendingSignaturesFlow->validationMessages as $validationMessage)
                                        <li class="list-group-item list-group-item-warning">
                                            {{$validationMessage}}
                                        </li>
                                    @endforeach
                                    <br>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>

            @if(!$hasValidationMessages)
                <button class="btn btn-primary" id="signBtn" type="submit">
                    <i class="fas fa-edit"></i> Firmar
                </button>
            @endif
        </div>
    </form>
</div>
