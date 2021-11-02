<div>
    <div class="px-4 space-y-4 mt-8">
        <form method="get">
            <input class="border-solid border border-gray-300 p-2 w-full md:w-1/4" 
                type="text" placeholder="Search Users" wire:model="term"/>
        </form>
        <div wire:loading>Buscando usuario...</div>
        <div wire:loading.remove>
        <!-- 
            notice that $term is available as a public 
            variable, even though it's not part of the 
            data array 
        -->
        @if ($term == "")
            <div class="text-gray-500 text-sm">
                Ingresa el usuario buscado.
            </div>
        @else
            @if($users->isEmpty())
                <div class="text-gray-500 text-sm">
                    No se encontraron resultados.
                </div>
            @else
                @foreach($users as $user)
                    <div>
                        <h3 class="text-lg text-gray-900 text-bold">{{$user->name}}</h3>
                        <p class="text-gray-500 text-sm">{{$user->email}}</p>
                        <p class="text-gray-500">{{$user->bio}}</p>
                    </div>
                @endforeach
            @endif
        @endif
        </div>
    </div>
    <div class="px-4 mt-4">
        {{$users->links()}}
    </div>
</div>
