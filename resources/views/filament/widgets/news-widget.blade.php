<x-filament-widgets::widget>
    <x-filament::section>
        <h3 class="text-lg font-bold">Últimas Noticias</h3>

        @foreach ($this->getNews() as $news)
            <div class="my-4">
                @if ($news->image)
                    <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-auto mb-4">
                @endif
                <h4 class="text-md font-bold">{{ $news->title }}</h4>
                <p style="white-space: pre-wrap;">{{ $news->body }}</p>
                <hr>
            </div>
        @endforeach
    </x-filament::section>
</x-filament-widgets::widget>
