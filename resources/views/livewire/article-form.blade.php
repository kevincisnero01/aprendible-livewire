<div>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('New Article') }}
    </h2>
</x-slot>
<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-form-section submit="save">

        <x-slot name="title">
            {{ __('New Article') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Some description') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-4 relative">
            @if($image)
                <x-danger-button wire:click="$set('image')" class="absolute bottom-2 right-2" >{{ __('Change Image') }}</x-danger-button>
                <image src="{{ $image?->temporaryUrl() }}" class="border-2 rounded" alt="imagen">
            @elseif($article->image)
                <x-label for="image" :value="__('Change Image')" class="absolute bottom-2 right-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"/>
                <img src="{{ Storage::disk('public')->url($article->image) }}" class="border-2 rounded" alt="imagen"> 
            @else
                <div class="h-32 bg-gray-50 border-2 border-dashed rounded flex items-center justify-center">
                    <x-label for="image" :value="__('Select Image')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"/>
                </div>
            @endif
                <x-input wire:model="image" id="image" type="file" class="mt-1 block w-full hidden"/>
                <x-input-error for="image" class="mt-1"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="title" :value="__('Titlte')" />
                <x-input wire:model="article.title" id="title" type="text" class="mt-1 block w-full"/>
                <x-input-error for="article.title" class="mt-1"/>
            </div>
            
            <div class="col-span-6 sm:col-span-4">
                <x-label for="slug" :value="__('Slug')" />
                <x-input wire:model="article.slug" id="slug" type="text" class="mt-1 block w-full"/>
                <x-input-error for="article.slug" class="mt-1"/>
            </div>  

            <div class="col-span-6 sm:col-span-4">
                <x-label for="content" :value="__('Content')" />
                <x-input-html-editor wire:model="article.content" id="content" class="mt-1 block w-full"/>
                <x-input-error for="article.content" class="mt-1"/>
            </div>
            
            <x-slot name="actions">
                <x-button>
                    {{ __('Save') }}
                </x-button>
            </x-slot>

        </x-slot>
    </x-form-section>
    </div>
</div>
</div>
