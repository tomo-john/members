<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sandbox as SandboxModel;

class Sandbox extends Component
{
    // Livewireプロパティ(フォーム)
    public $name;
    public $is_good_boy = true;
    public $birthday;
    public $mood = SandboxModel::MOOD_IDLE;

    // Livewireプロパティ(一覧表示)
    public $sandboxes;

    // 初回に一覧を取得
    public function mount()
    {
        $this->sandboxes = SandboxModel::latest()->get();
    }

    // 保存処理
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

    // 編集
    public function edit(int $id)
    {

    }

    // 削除
    public function delete(int $id)
    {
        $sandbox = SandboxModel::findOrFail($id);
        $sandbox->delete();
        $this->sandboxex = $this->sandboxes->reject(fn($s) => $s->id === $id);
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

    // 表示するBlade
    public function render()
    {
        return view('livewire.sandbox');
    }
}
