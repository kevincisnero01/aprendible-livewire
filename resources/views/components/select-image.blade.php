<div class="relative">
@php($id = $attributes->wire('model')->value)
@if($image instanceof Livewire\TemporaryUploadFile )
    <x-danger-button wire:click="$set('{{$id}}')" class="absolute bottom-2 right-2" >
        {{ __('Change Image') }}
    </x-danger-button>
    <image src="{{ $image?->temporaryUrl() }}" class="border-2 rounded" alt="imagen">
@elseif($existing)
    <x-label :for="$id" :value="__('Change Image')" class="absolute bottom-2 right-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"/>
    <img src="{{ Storage::disk('public')->url($existing) }}" class="border-2 rounded" alt="imagen"> 
@else
    <div class="h-32 bg-gray-50 border-2 border-dashed rounded flex items-center justify-center">
        <x-label :for="$id" :value="__('Select Image')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"/>
    </div>
@endif
    <x-input wire:model="{{$id}}" :id="$id" type="file" class="mt-1 block w-full hidden"/>
</div>