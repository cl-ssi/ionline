<x-filament-widgets::widget>
    <x-filament::section>
        <h3 class="text-lg font-bold">Últimas Noticias</h3>

        @foreach ($this->getNews() as $news)
            <div class="my-4">
                <h4 class="text-md font-semibold">{{ $news->title }}</h4>
                <p>{{ $news->body }}</p>
                @if ($news->image)
                    <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-auto mb-4">
                @endif
                <hr>
            </div>
        @endforeach
    </x-filament::section>
</x-filament-widgets::widget>
