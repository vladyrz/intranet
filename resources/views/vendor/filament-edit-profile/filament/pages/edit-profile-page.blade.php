<x-filament-panels::page>
    @foreach ($this->getRegisteredCustomProfileComponents() as $component)
        @unless(is_null($component))
            @livewire($component)
        @endunless
    @endforeach

    @livewire('subscription-status')
</x-filament-panels::page>