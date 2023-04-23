<div class="py-10">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between">
        <x-input 
            wire:model="search" 
            type="text" 
            placeholder="Search..."
        />

        <x-button-link href="{{ route('articles.create') }}" >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

            {{ __('New Article') }}
        </x-button-link>
    </div>
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr>
                    <th scope="col" class="p-4" >
                        <button wire:click="sortBy('title')" class="flex items-center uppercase hover:underline">
                            {{ __('Title') }}
                            @if($sortField == "title")
                                <svg class="w-3 h-3 ml-1 duration-200 @if($sortDirection === 'desc') rotate-180 @endif " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <button wire:click="sortBy('created_at')" class="flex gap-x-2">
                            {{ __('Created At') }}
                            @if($sortField == "created_at")
                                <svg class="w-3 h-3 ml-1 duration-200 @if($sortDirection === 'desc') rotate-180 @endif " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <th class="flex items-center gap-2 px-6 py-4 text-gray-900">
                        <img class="w-10 h-10 rounded-full border border-gray-300" src="{{ $article->image_url }}" alt="Imagen Article">
                        <a href="{{ route('articles.show', $article) }}"> 
                            {{ $article->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        {{ $article->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4r">
                        <div class="flex justify-between items-center">
                            <a href="{{ route('articles.edit', $article->id) }}" class="inline-block font-medium text-blue-600"> 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
    
                            <livewire:article-delete-modal wire:key="{{'article-delete-button-'.$article->id}}" :article="$article">
                                <button class="" wire:click="$emit('confirmArticleDeletion', {{ $article }}) ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-red-500 hover:text-red-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </livewire:article-delete-modal>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-2 bg-gray-50 bt-2">
            {{ $articles->links()}}
        </div>
    </div>
</div>
</div>
