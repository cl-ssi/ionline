<div>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" checked="{{$checked}}" wire:model.live="checked" id="institutionalPaymentSwitch-{{$dteId}}">
        <label class="form-check-label" for="institutionalPaymentSwitch-{{$dteId}}">Manual</label>
    </div>
    <i class="fa fa-spinner fa-spin" wire:loading></i>
</div>
