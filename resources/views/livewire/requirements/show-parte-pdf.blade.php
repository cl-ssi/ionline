<div class="col-8">
    @if($parte->files->first() != null)

        @if($parte->files->count() > 1)

            <select name="files" id="for_files" wire:model="selectedKey" class="form-control-sm">
                @foreach($parte->files as $key => $file)
                    <option value={{$key}}>{{$file->name}}</option>
                @endforeach
            </select>

            <object type="application/pdf"
                    data="{{route('documents.partes.download', $parte->files[$selectedKey]->id)}}"
                    width="100%"
                    height="100%">
            </object>

        @else
            <object type="application/pdf"
                    data="{{route('documents.partes.download', $parte->files->first()->id)}}"
                    width="100%"
                    height="100%">
            </object>
        @endif

    @endif
</div>
