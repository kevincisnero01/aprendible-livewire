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
                <x-input-textarea wire:model="article.content" id="content" class="mt-1 block w-full"/>
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
