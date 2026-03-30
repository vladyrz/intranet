<div class="mt-4">
    <x-filament::section>
        <x-slot name="heading">
            Información del Asesor
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">País</p>
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">{{ $flag }}</span>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ $country }}
                    </h3>
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-500">Código de Asesor</p>
                <h3 class="text-lg font-bold text-primary-600 dark:text-primary-400">
                    {{ $code }}
                </h3>
            </div>
        </div>
    </x-filament::section>
</div>