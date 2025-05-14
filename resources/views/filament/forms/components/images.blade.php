<x-filament::input.wrapper>
    <x-filament::input
        type="file"
        wire:model="images"
        {{ $attributes->merge(['class' => 'block w-full mt-1']) }}
    />
</x-filament::input.wrapper>
