<div>

    <div wire:ignore>
        <select class="form-control">
            <option selected="selected">orange</option>
            <option>white</option>
            <option>purple</option>
            <option>sadf</option>
            <option>sdf</option>
        </select>


    </div>
    
    <div wire:ignore.self>
            <div class="form-group">
                <label for="exampleInputRounded0">Section Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-globe-asia text-primary"></i></span>
                    </div>
                    <select class="form-control rounded-0 " wire:change="$emit('classChanged', $event.target.value)" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option>white</option>
            <option>purple</option>
            <option>sadf</option>
            <option>sdf</option>
                    </select>
                </div>
                @error('cr_classes_sec_id') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
        </div>


    @push('scripts')
        <script>
            $(".js-example-tags").select2({
                tags: true
            });
        </script>
    @endpush
</div>
