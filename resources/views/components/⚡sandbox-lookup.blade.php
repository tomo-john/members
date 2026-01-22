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
};

?>

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium">Sandbox ID</label>
        <input type="number"
               wire:model.live.debounce.500ms.number="sandboxId"
               class="border rounded px-3 py-2 w-full"
               placeholder="IDを入力">
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
        @else
            <p class="text-sm text-gray-400">
                データはありません
                <i class="fa-solid fa-dog"></i>
            </p>
        @endif
    </div>
</div>
