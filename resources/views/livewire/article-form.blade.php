<div>
<div class="container mx-auto py-4 px-8">

    <h1 class="text-3xl font-bold underline my-2">Formulario</h1>
    
    <a class="px-4 py-1 bg-gray-200 rounded hover:bg-gray-300" href="{{ route('articles.index') }}" >Listado de  Articulo</a>

    <form wire:submit.prevent="save">
        <label class="block my-4">
            <input wire:model="title" type="text" placeholder="Titulo..." class="rounded">
            @error('title') <div>{{ $message }}</div> @enderror
        </label>

        <label class="block my-4">
            <textarea wire:model="content" placeholder="Contenido..." class="rounded"></textarea>
            @error('content') <div>{{ $message }}</div> @enderror
        </label>

        <button type="submit" class="px-4 py-1 bg-gray-200 rounded hover:bg-gray-300" >
            Enviar
        </button>
    </form>
</div>
</div>
