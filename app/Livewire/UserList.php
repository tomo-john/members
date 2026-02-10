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

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $this->users = $this->users->reject(fn ($user) => $user->id === $id);
        session()->flash('message', 'ユーザーを削除しました');
    }

    public function render()
    {
        return view('livewire.user-list');
    }
}
