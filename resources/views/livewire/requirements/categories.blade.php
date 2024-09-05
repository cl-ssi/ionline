<div>
    @include('requirements.partials.nav')

    @section('title', 'Categorías')

    @if ($form)
        <h3>{{ $categoryName ? 'Editar' : 'Crear' }} Categoría</h3>
        
        <div class="form-row mb-3">
            <fieldset class="col-12 col-md-6">
                <label for="for-name">Nombre*</label>
                <input type="text" wire:model="categoryName" class="form-control">
                @error('categoryName') <span class="text-danger">{{ $message }}</span> @enderror
            </fieldset>
        </div>
        
        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
                @if($category->requirements()->exists())
                <button type="button" class="btn btn-danger" disabled>
                    <i class="fas fa-trash" title="no se puede eliminar, tiene requerimientos asociados"></i>
                </button>
                @else
                <button type="button" class="btn btn-danger" 
                    onclick="confirm('¿Está seguro que desea borrar la categoría {{ $category->name }} de su unidad organizacional?') || event.stopImmediatePropagation()" 
                    wire:click="delete({{$category}})"><i class="fas fa-trash"></i>
                </button>
                @endif
            </div>
        </div>
    @else
        <div class="form-row">
            <div class="col-12 col-md-9">
                <h3>Categorías de: <small> {{ auth()->user()->organizationalUnit->name }}</small></h3>
            </div>
            <div class="col-12 col-md-3 text-end">
                <button class="btn btn-success float-right" wire:click="editForm()">
                    <i class="fas fa-plus"></i> Nueva categoría
                </button>
            </div>
        </div>

        <ul>
            <li>Las categorías son comunes para todas las personas de una misma unidad organizacional</li>
            <li>Un requerimiento sólo puede tener una categoría</li>
            <li>Ejemplos de categorías: "Reseteo de clave de correo", "Arreglo de cañería", "Compra con caja chica", etc</li>
            <li>Son otra forma de agrupar los requerimientos</li>
        </ul>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th width="60"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>
                        <i class="fas fa-copyright"></i> {{ $category->name }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" 
                            wire:click="editForm({{$category}})"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>