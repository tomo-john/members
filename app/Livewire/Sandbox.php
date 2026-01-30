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
    public $editingId = null; // 編集中flg

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
        if ($this->birthday === '') {
            $this->birthday = null;
        }

        $validated = $this->validate([
            'name' => 'required|max:20',
            'is_good_boy' => 'boolean',
            'birthday' => 'nullable|date',
            'mood' => 'required|in:' . implode(',', SandboxModel::MOODS),
        ]);

        if($this->editingId !== null) {
            // 更新
            $sandbox = SandboxModel::findOrFail($this->editingId);
            $sandbox->update($validated);

            $this->sandboxes = $this->sandboxes->map(
                fn($s) => $s->id === $sandbox->id ? $sandbox : $s
            );

            session()->flash('message', $sandbox->name . ' を更新しました');
            session()->flash('type', 'update');
        } else {
            // 新規作成
            $sandbox = SandboxModel::create($validated);

            $this->sandboxes->prepend($sandbox);

            session()->flash('message', $sandbox->name . ' を登録しました');
            session()->flash('type', 'create');
        }

        $this->resetForm();
    }

    // 編集
    public function edit(int $id)
    {
        $sandbox = SandboxModel::findOrFail($id);

        $this->name = $sandbox->name;
        $this->is_good_boy = $sandbox->is_good_boy;
        $this->birthday = optional($sandbox->birthday)->format('Y-m-d');
        $this->mood = $sandbox->mood;
        $this->editingId = $sandbox->id;
    }

    // 削除
    public function delete(int $id)
    {
        $sandbox = SandboxModel::findOrFail($id);
        $sandbox->delete();

        $this->sandboxes = $this->sandboxes->reject(
            fn($s) => $s->id === $id
        );

        session()->flash('message', $sandbox->name . ' を削除しました');
        session()->flash('type', 'delete');

        $this->resetForm();
    }

    // フォームリセット
    public function resetForm()
    {
        $this->reset([
            'name',
            'is_good_boy',
            'birthday',
            'editingId'
        ]);

        $this->is_good_boy = true;
        $this->mood = SandboxModel::MOOD_IDLE;

        $this->resetValidation();
    }

    public function updatedBirthday($value)
    {
        if ($value === '') {
            $this->birthday = null;
        }
    }

    // 表示するBlade
    public function render()
    {
        return view('livewire.sandbox');
    }
}
