<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasUser;

class UserCountryForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use HasUser;

    public ?array $data = [];

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->form->fill($this->user->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información de Ubicación')
                    ->aside()
                    ->description('Actualiza tu país de residencia para generar tu código de asesor.')
                    ->schema([
                        Select::make('country_id')
                            ->label('País')
                            ->options(\App\Models\Country::where('is_active', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ]),
            ])
            ->statePath('data')
            ->model($this->user);
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $this->user->update($data); // This will trigger the model events

        Notification::make()
            ->success()
            ->title('Información actualizada correctamente')
            ->send();

        // Emit event to refresh other components if needed (e.g. the code display)
        $this->dispatch('user-updated');

        // Force refresh of the current component to reflect changes (if any logic depends on re-render)
        return;
    }

    public function render(): View
    {
        return view('livewire.user-country-form');
    }
}
