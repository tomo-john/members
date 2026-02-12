<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;
    public $roles;

    public function mount(): void
    {
        $this->roles = Role::all();
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        // $this->users = $this->users->reject(fn ($user) => $user->id === $id);
        session()->flash('message', 'ユーザーを削除しました');
    }

    public function toggleRole($userId, $roleId)
    {
        $user = User::findOrFail($userId);

        if ($user->roles->contains($roleId)) {
            $user->roles()->detach($roleId);
        } else {
            $user->roles()->attach($roleId);
        }
    }

    public function render()
    {
        return view('livewire.user-list', [
            'users' => User::paginate(10)
        ]);
    }
}
