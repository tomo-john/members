<?php

use Livewire\Component;
use App\Models\Dog;

new class extends Component
{
    public $name;
    public $birthday;
    public $is_good_boy;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:50',
            'birthday' => 'nullable|date',
            'is_good_boy' => 'nullable|boolean',
        ]);

        $validated['is_good_boy'] ??= false;

        Dog::create($validated);

        $this->reset([
            'name',
            'birthday',
            'is_good_boy'
        ]);

        $this->resetValidation();
    }
};
?>

<div>
    <h2 class="text-2xl text-white font-semibold">
        Dog
        <i class="fa-solid fa-dog ml-2"></i>
    </h2>

    <div class="max-w-2xl mx-auto space-y-4 border rounded-2xl mt-6 p-6">
        <flux:input label="Dog name" wire:model="name" placeholder="例: じょん" />
        <flux:input label="Birthday" wire:model="birthday" type="date" />
        <flux:checkbox label="Good Boy? 🐶" wire:model="is_good_boy" />
        <flux:button wire:click="save">保存</flux:button>
    </div>
</div>
