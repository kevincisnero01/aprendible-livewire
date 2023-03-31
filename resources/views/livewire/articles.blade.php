<div>
<div class="container mx-auto">
    <h1 class="text-3xl font-bold underline">Lista de Articulos</h1>

    <ul class="list-disc">
        @foreach($articles as $article)
        <li>{{ $article->name }}</li>
        @endforeach
    </ul>
</div>
</div>
