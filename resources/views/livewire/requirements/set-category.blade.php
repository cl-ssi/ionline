<div>
	<div class="dropdown">
		<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
			Categorías
		</button>

		<div class="dropdown-menu">
			@foreach(auth()->user()->reqCategories as $category)
			<a class="dropdown-item" href="#" wire:click="setCategory({{$category->id}})">
				<span 
					class='badge badge-primary' 
					style='background-color: #{{ $category->color }};'>
					{{ $category->name }}
				</span>
				@if(in_array($category->id, $reqCategoriesArray))
				<i class="fas fa-check"></i>
				@endif
			</a>
			@endforeach
		</div>

		@foreach($reqCategories as $category)
		<span 
			class='badge badge-primary' 
			style='background-color: #{{ $category->color }};'>
			{{ $category->name }}
		</span>
		@endforeach

	</div>

</div>