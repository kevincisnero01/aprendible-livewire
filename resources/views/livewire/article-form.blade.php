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

            <div class="col-span-6 sm:col-span-4">
                <x-select-image wire:model="image" :image="$image" :existing="$article->image"/>
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
                <x-label for="category_id" :value="__('Category')" />
                <div class="flex gap-1 mt-1">
                    <x-input-select wire:model="article.category_id" id="category_id" :options="$categories" :placeholder="__('Select Category')" class="block w-full"/>
                    <x-secondary-button class="!p-2.5" wire:click="$set('showCategoryModal', true)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </x-secondary-button>
                </div>
                <x-input-error for="article.category_id" class="mt-1"/>
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

<x-dialog-modal wire:model="showCategoryModal">
    <x-slot name="title">Modal Title</x-slot>
    <x-slot name="content">Modal Content</x-slot>
    <x-slot name="footer">
        <x-secondary-button wire:click="$set('showCategoryModal',false)">
            Cancel
        </x-secondary-button>
    </x-slot>
</x-dialog-modal>
</div>
