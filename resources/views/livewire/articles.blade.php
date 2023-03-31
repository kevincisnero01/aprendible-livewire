<div>
<div class="container mx-auto">
    <h1 class="text-3xl font-bold underline">Lista de Articulos</h1>

    <input 
        wire:model="search" 
        type="text" 
        class="rounded px-3 py-0 my-2"
        placeholder="Buscar..."
    >

    <ul class="list-disc">
        @foreach($articles as $article)
        <li>{{ $article->name }}</li>
        @endforeach
    </ul>
</div>
</div>
