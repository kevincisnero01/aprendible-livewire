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
        <li>{{ $article->title }}</li>
        @endforeach
    </ul>
</div>
</div>
