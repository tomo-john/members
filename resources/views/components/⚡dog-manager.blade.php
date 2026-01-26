<?php

use Livewire\Component;
use App\Models\Dog;

new class extends Component
{
    public $name;
    public $birthday;
    public $is_good_boy;
    public $dogs;
    public ?int $editingDogId = null;

    // mountは最初に起動したとき1回実行される
    public function mount()
    {
        $this->dogs = Dog::latest()->get();
    }

    // 保存処理(新規・更新どちらも対応)
    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:50',
            'birthday' => 'nullable|date',
            'is_good_boy' => 'nullable|boolean',
        ]);

        $validated['is_good_boy'] ??= false;

        if ($this->editingDogId) {
            // 更新
            $dog = Dog::findOrFail($this->editingDogId);
            $dog->update($validated);

            $this->dogs = $this->dogs->map(
                fn ($d) => $d->id === $dog->id ? $dog : $d
            );

            session()->flash('message', '更新しました');
        } else {
            $dog = Dog::create($validated);
            $this->dogs->prepend($dog);


            session()->flash('message', '保存しました');
        }

        $this->resetForm();
    }

    // 削除処理
    public function delete(int $dogId)
    {
        Dog::where('id', $dogId)->delete();

        $this->dogs = $this->dogs->reject(fn($dog) => $dog->id === $dogId);

        session()->flash('message', '削除しました');
    }

    // 更新処理
    public function update(int $dogId)
    {
        $dog = Dog::findOrFail($dogId);

        $this->editingDogId = $dog->id;
        $this->name = $dog->name;
        $this->birthday = $dog->birthday?->format('Y-m-d');
        $this->is_good_boy = $dog->is_good_boy;
    }

    // フォームリセット
    public function resetForm()
    {
        $this->reset([
            'name',
            'birthday',
            'is_good_boy',
            'editingDogId',
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

    <!-- 犬アイコンとフラッシュメッセージ -->
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
                <div
                    wire:key="{{ session('message') . now() }}"
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 2000)"
                    x-show="show"
                    x-transition.duration.500ms
                    class="absolute left-32 ml-4"
                >

                    <div class="relative bg-green-900/60 text-green-200 px-4 py-3 rounded-xl max-w-xs whitespace-nowrap flex-items-center">
                        {{ session('message') }}
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- 入力フォーム -->
    <div class="max-w-2xl mx-auto space-y-4 border rounded-2xl mt-6 p-6">
        <flux:input label="Dog name" wire:model="name" placeholder="例: じょん" />
        <flux:input label="Birthday" wire:model="birthday" type="date" />
        <flux:checkbox label="Good Boy? 🐶" wire:model="is_good_boy" />
        <flux:button wire:click="save">
            {{ $editingDogId ? '更新' : '保存' }}
        </flux:button>
    </div>

    <!-- Dog 一覧 -->
    <div class="max-w-2xl mx-auto mt-8 space-y-3">
        <h2 class="text-xl font-semibold text-center">INDEX</h2>
        @forelse ($dogs as $dog)
            <div wire:key="dog-{{ $dog->id }}" class="flex items-center gap-3">
                <div class="flex justify-between items-center border rounded-xl p-4 flex-1">
                    <div>
                        <p class="font-semibold">{{ $dog->name }}</p>
                        <p class="text-sm text-gray-400">
                            {{ $dog->birthday?->format('Y-m-d') ?? '誕生日未登録' }}
                        </p>
                    </div>

                    <div>
                        @if ($dog->is_good_boy)
                            <span class="text-green-400">Good Boy <i class="fa-solid fa-dog"></i></span>
                        @else
                            <span class="text-gray-400"><i class="fa-solid fa-dog"></i></span>
                        @endif
                    </div>
                </div>

                <!-- 編集アイコン -->
                <div>
                    <i
                        wire:click="update({{ $dog->id }})"
                        class="fa-solid fa-pen cursor-pointer hover:text-blue-500"
                    ></i>
                </div>

                <!-- 削除アイコン -->
                <div>
                    <i
                        wire:click="delete({{ $dog->id }})"
                        wire:confirm="削除してよろしいですか？"
                        class="fa-solid fa-trash cursor-pointer hover:text-red-500"
                    ></i>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-400">
                まだ犬がいません
                <i class="fa-solid fa-dog"></i>
            </p>
        @endforelse
    </div>
</div>
