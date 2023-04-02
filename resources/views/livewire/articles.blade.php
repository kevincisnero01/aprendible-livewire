<div>
<div class="container mx-auto py-4 px-8">
    <h1 class="text-3xl font-bold underline">Lista de Articulos</h1>
    

    <input 
        wire:model="search" 
        type="text" 
        class="rounded px-3 py-0 my-2"
        placeholder="Buscar..."
    >

    <a class="px-4 py-1 bg-gray-200 rounded hover:bg-gray-300" href="{{ route('articles.create') }}" >Crear Articulo</a>
    
    <ul class="list-disc list-inside">
        @foreach($articles as $article)
            <li>
                <a href="{{ route('articles.show', $article) }}">
                    {{ $article->title }}
                </a>
                <a href="{{ route('articles.edit', $article) }}" class="px-2 underline text-blue-600 active:text-blue-800">
                    Editar
                </a>
            </li>
        @endforeach
    </ul>
</div>
</div>
