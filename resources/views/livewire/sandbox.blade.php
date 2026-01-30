<div>
    <div class="max-w-3xl mx-auto">
        <h2 class="text-3xl font-semibold text-center">
            <i class="fa-solid fa-dog mx-2"></i>
            Sand Box
            <i class="fa-solid fa-dog mx-2"></i>
        </h2>
    </div>

    <!-- フラッシュメッセージ(トースト風) -->
    @if (session()->has('message'))
        <div
            wire:key="{{ session('message') . now() }}"
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="fixed top-8 right-8 z-50"
        >
            @php
                [$bgClass, $icon] = match(session('type')) {
                    'create' => ['bg-green-600', 'fa-solid fa-plus-circle'],
                    'update' => ['bg-blue-600', 'fa-solid fa-pen-square'],
                    'delete' => ['bg-red-600', 'fa-solid fa-trash-can'],
                    default => ['bg-gray-600', 'fa-solid fa-check'],
            };
            @endphp
            <div class="{{ $bgClass }} text-white text-sm rounded-lg px-4 py-3 shadow-2xl flex items-center gap-3 border border-white/20">
                <i class="{{ $icon }}"></i>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- フォーム -->
    <div class="max-w-3xl mx-auto border rounded-md space-y-4 p-4 m-4">
        <h2 class="text-2xl font-semibold ">
            {{ $editingId ? 'Edit' : 'Form' }}
        </h2>
        <flux:input label="Name" icon="face-smile" wire:model="name" placeholder="じょん・どぅ" />
        <flux:checkbox label="Is good boy? 🐶" wire:model="is_good_boy" />
        <flux:input label="Birthday" icon="cake" wire:model="birthday" type='date' />
        <flux:button wire:click="save">
            {{ $editingId ? '更新する' : '保存する' }}
        </flux:button>
        @if($editingId)
            <flux:button variant="ghost" wire:click="resetForm">キャンセル</flux:button>
        @endif
    </div>


    <!-- Index (カードグリッド) -->
    <div class="max-w-3xl mx-auto border rounded-md space-y-4 p-4 m-4">
        <h2 class="text-2xl font-semibold ">Index</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($sandboxes as $sandbox)
                <div wire:key="sandbox-{{ $sandbox->id }}" class="bg-gray-100 rounded-lg p-4 shadow space-y-2">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-500">
                            {{ $sandbox->name }}
                        </h3>

                        @if($sandbox->is_good_boy)
                            <span class="text-green-600 text-sm">Good Boy 🐶</span>
                        @else
                            <span class="text-gray-400 text-sm">Devil 👿</span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600">
                        🎂 {{ $sandbox->birthday?->format('Y-m-d') ?? 'Unknown' }}
                    </p>

                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-block text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                            mood: {{ $sandbox->mood }}
                        </span>
                        <div class="flex gap-2">
                            <button wire:click="edit({{ $sandbox->id }})" class="p-2 rounded-full text-blue-500 hover:bg-blue-50 hover:text-blue-600 transition-colors cursor-pointer">
                                <i class="fa-solid fa-paw"></i>
                            </button>
                            <button wire:click="delete({{ $sandbox->id }})"
                                    wire:confirm="本当に削除してよろしいですか？🐶"
                                    class="p-2 rounded-full text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors cursor-pointer"
                            >
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p>No data</p>
            @endforelse
        </div>
    </div>
</div>
