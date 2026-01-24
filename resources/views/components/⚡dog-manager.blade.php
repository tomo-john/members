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

        session()->flash('message', '保存しました');
    }
};
?>

<div>
    <h2 class="text-2xl text-white font-semibold">
        Dog
        <i class="fa-solid fa-dog ml-2"></i>
    </h2>

    <div class="flex justify-center mt-6">
        <div class="relative flex items-center">

            <!-- 犬: 幅を固定 -->
            <div class="w-32 flex justify-center">
                <div class="w-32 h-32 flex justify-center items-center rounded-full bg-gray-600">
                    <i class="fa-solid fa-dog text-5xl text-white"></i>
                </div>
            </div>

            <!-- 吹き出し: 犬の横に重ねる -->
            @if (session()->has('message'))
                <div class="absolute left-32 ml-4">
                    <div class="relative bg-green-900/60 text-green-200 px-4 py-3 rounded-xl max-w-xs whitespace-nowrap flex-items-center">
                        {{ session('message') }}
                    </div>
                </div>
            @endif

        </div>
    </div>

    <div class="max-w-2xl mx-auto space-y-4 border rounded-2xl mt-6 p-6">
        <flux:input label="Dog name" wire:model="name" placeholder="例: じょん" />
        <flux:input label="Birthday" wire:model="birthday" type="date" />
        <flux:checkbox label="Good Boy? 🐶" wire:model="is_good_boy" />
        <flux:button wire:click="save">保存</flux:button>
    </div>
</div>
