<?php

namespace App\Livewire;

use Livewire\Component;

class UserCodeDisplay extends Component
{
    protected $listeners = ['user-updated' => '$refresh'];

    public function render()
    {
        $user = auth()->user();

        return view('livewire.user-code-display', [
            'user' => $user,
            'country' => $user->country ? $user->country->name : 'No asignado',
            'code' => $user->code ?? 'Pendiente',
            'flag' => $user->country ? $user->country->emoji : '🏳️',
        ]);
    }
}
