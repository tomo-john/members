<?php

use Livewire\Component;
use App\Models\Sandbox;

new class extends Component
{
    public $sandbox;
    public $sandboxId;
    public $scheduledAt;

    // mount()は初期化専用
    // select用データはここで取る
    public function mount()
    {
        $this->sandbox = Sandbox::select('id', 'name')->get();
    }

    // updatedは特別
    // $sandboxIdが変わったら反応
    public function updatedSandboxId()
    {
        $sandbox = Sandbox::find($this->sandboxId);
        $this->scheduledAt = $sandbox?->scheduled_at;
    }

    // 更新処理
    public function save()
    {
        Sandbox::where('id', $this->sandboxId)
            ->update([
                'scheduled_at' => $this->scheduledAt,
            ]);
    }

    // テーブルリセット
    public function resetTable()
    {
        Sandbox::truncate();

        $this->reset([
            'sandboxId',
            'scheduledAt',
        ]);
    }

};

?>

<div class="space-y-4">
    <flux:select label="Snadbox ID"
                 wire:model.live="sandboxId"
    >
        <option value="">選択して下さい🐶</option>

        @foreach ($sandbox as $s)
            <option value="{{ $s->id }}">
                #{{ $s->id }} - {{ $s->name }}
            </option>
        @endforeach

    </flux:select>

    <!-- ローディング中を表示 -->
    <div wire:loading>
        <p class="text-sm text-gray-400">読み込み中です... 🐶</p>
    </div>

    <!-- ローディング中は結果を隠す -->
    <div wire:loading.remove>
        @if($scheduledAt)
            <div class="text-sm">
                <p>scheduled_at</p>
                <p class="font-semibold">
                    {{ $scheduledAt->translatedFormat('Y年m月d日 H:i') }}
                </p>
                <p class="text-xs text-gray-500">
                    {{ $scheduledAt->diffForHumans() }}
                </p>
            </div>

            <div class="mt-4 space-y-4">
                <flux:input type="date"
                            label="new_scheduled_at"
                            wire:model="scheduledAt"
                            view="calendar" />
                <flux:button variant="primary" wire:click="save">更新</flux:button>
            </div>
        @else
            <p class="text-sm text-gray-400">
                データはありません
                <i class="fa-solid fa-dog"></i>
            </p>
        @endif
    </div>

    <div>
        <flux:button
            variant="danger"
            wire:click="resetTable"
            wire:confirm="本当にテーブルをリセットしますか？🐶"
        >
            テーブルリセット
        </flux:button>
    </div>
</div>
