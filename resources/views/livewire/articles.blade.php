<div>
    <h1>Lista de Articulos</h1>

    <ul>
        @foreach($articles as $article)
        <li>{{ $article->name }}</li>
        @endforeach
    </ul>

</div>
