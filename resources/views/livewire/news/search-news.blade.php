<div>
    @include('news.partials.nav')

    <h4><i class="far fa-newspaper mt-3"></i> Todas las Noticias aquí</h4>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="text-center">
                    <th>N°</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Publicación</th>
                    <th>Titular</th>
                    <th>Publicada en Home hasta</th>
                    <th>Creada por</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($newsList as $news)
                <tr>
                    <td class="text-center">{{ $news->id }}</td>
                    <td class="text-center">{{ $news->created_at->format('d-m-Y H:i:s') }}</td>
                    <td class="text-center">{{ $news->publication_date_at->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $news->title }}</td>
                    <td class="text-center">{{ $news->until_at->format('d-m-Y') }}</td>
                    <td>{{ $news->user->TinnyName }}</td>
                    <td class="text-center">
                        @if($news->user_id == auth()->user()->id)
                        <a class="btn btn-outline-secondary btn-sm" 
                            title="Selección"
                            href="{{ route('news.edit', $news) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                        <a class="btn btn-outline-secondary btn-sm" 
                            title="Selección"
                            href="{{ route('news.show', $news) }}">
                            <i class="far fa-newspaper"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
