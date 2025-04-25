<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}

            {{ $this->registerAction }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.before') }}

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.after') }}

    <div class="mt-4 text-center">
        <a href="{{ route('legal.notice') }}"
           class="inline-block text-sm font-semibold text-purple-600 hover:text-purple-700 hover:underline transition duration-300">
            Términos y Condiciones
        </a>
    </div>


</x-filament-panels::page.simple>
