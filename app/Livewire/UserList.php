<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserList extends Component
{
    public $users;

    public function mount(): void
    {
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.user-list');
    }
}
