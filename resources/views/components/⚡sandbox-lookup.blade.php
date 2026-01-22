<?php

use Livewire\Component;
use App\Models\Sandbox;

new class extends Component
{
    public $sandboxId;
    public $scheduledAt;

    public function updatedSandboxId()
    {
        $sandbox = Sandbox::find($this->sandboxId);
        $this->scheduledAt = $sandbox?->scheduled_at;
    }

    public function save()
    {
        Sandbox::where('id', $this->sandboxId)
            ->update([
                'scheduled_at' => $this->scheduledAt,
            ]);
    }
};

?>

<div class="space-y-4">
    <div>
        <flux:input type="number"
                    label="Snadbox ID"
                    wire:model.live.debounce.500ms.number="sandboxId"
                    placeholder="IDを入力" />
    </div>

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
                            name="scheduled_at"
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
</div>
