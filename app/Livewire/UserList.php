<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class UserList extends Component
{
    use WithPagination;
    public $roles;
    public $search = '';

    public function mount(): void
    {
        $this->roles = Role::all();
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // 役割の削除
        $user->roles()->detach();

        // アバター画像の削除
        if ($user->avatar && $user->avatar !== 'user_default.jpg') {
            Storage::disk('public')->delete('avatar/' . $user->avatar);
        }

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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where('email', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%");
        }

        return view('livewire.user-list', [
            'users' => $query->paginate(10)
        ]);
    }
}
