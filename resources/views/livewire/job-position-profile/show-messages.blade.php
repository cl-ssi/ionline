<div>
    @foreach($messages as $message)
    <div class="card" id="message">
        <div class="card-header col-sm">
            <i class="fas fa-user"></i> {{ $message->user->fullName }}
        </div>
        <div class="card-body">
            <i class="fas fa-calendar"></i> {{ $message->created_at->format('d-m-Y H:i:s') }}<br>
            <i class="fas fa-info-circle"></i> {{ $message->SectionValue }}<br><br>
            <p class="font-italic"><i class="fas fa-comment"></i> "{{ $message->message }}"</p>
        </div>
    </div>
    <br>
    @endforeach
</div>
