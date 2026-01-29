<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sandbox as SandboxModel;

class Sandbox extends Component
{
    public $name;
    public $is_good_boy = true;
    public $birthday;
    public $mood = SandboxModel::MOOD_IDLE;

    public $sandboxes;

    public function mount()
    {
        $this->sandboxes = SandboxModel::latest()->get();
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|max:20',
            'is_good_boy' => 'boolean',
            'birthday' => 'nullable|date',
            'mood' => 'required|in:' . implode(',', SandboxModel::MOODS),
        ]);

        $sandbox = SandboxModel::create($validated);
        $this->sandboxes->prepend($sandbox);

        $this->resetForm();
    }

    // フォームリセット
    public function resetForm()
    {
        $this->reset([
            'name',
            'is_good_boy',
            'birthday',
            'mood',
        ]);

        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.sandbox');
    }
}
