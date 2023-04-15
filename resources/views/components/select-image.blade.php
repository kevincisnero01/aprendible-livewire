<div x-data="{ focused: false }" class="relative">

@php($id = $attributes->wire('model')->value)
@if($image instanceof Livewire\TemporaryUploadedFile)
    <x-danger-button wire:click="$set('{{$id}}')" class="absolute bottom-2 right-2" >
        {{ __('Change Image') }}
    </x-danger-button>
    <image src="{{ $image?->temporaryUrl() }}" class="border-2 rounded" alt="imagen">
@elseif($existing)
    <label for="{{ $id }}"  
        class="absolute bottom-2 right-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md
        font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700  transition ease-in-out duration-150 active:bg-gray-900"
        :class="{'bg-gray-700 outline-none ring-2 ring-indigo-500 ring-offset-2': focused}"
    >
        {{ __('Change Image') }}
    </label>
    
    <img src="{{ Storage::disk('public')->url($existing) }}" class="border-2 rounded" alt="imagen"> 
@else
    <div class="h-32 bg-gray-50 border-2 border-dashed rounded flex items-center justify-center">
        <label for="{{ $id }}" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700
            active:bg-gray-900  transition ease-in-out duration-150"
            :class="{'bg-gray-700 outline-none ring-2 ring-indigo-500 ring-offset-2': focused}"
        >
            {{ __('Select Image') }}
        </label>
    </div>
@endif
    @unless($image)
        <x-input 
            x-on:focus="focused = true"
            x-on:blur="focused = false" 
            wire:model="{{$id}}" 
            :id="$id" 
            type="file" 
            class="mt-1 block w-full sr-only"
        />
    @endunless
</div>