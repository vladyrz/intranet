<div class="mt-4">
    <form wire:submit="submit">
        {{ $this->form }}

        <div class="mt-4 flex justify-end">
            <x-filament::button type="submit">
                Guardar
            </x-filament::button>
        </div>
    </form>
</div>