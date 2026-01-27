<?php

use Livewire\Component;
use App\Models\Task;

new class extends Component
{
    // プロパティ
    public ?string $title;
    public ?string $due_date = null;
    public bool $is_done = false;
    public string $priority = 'medium';

    public array $priorities = [
        'low' => '低',
        'medium' => '中',
        'high' => '高',
    ];

    public $tasks;

    // 初期処理
    public function mount()
    {
        $this->tasks = Task::latest()->get();
        $this->priority = 'medium';
    }

    // 保存処理
    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:50',
            'due_date' => 'nullable|date',
            'is_done' => 'nullable|boolean',
            'priority' => 'required|in:low,medium,high',
        ]);

        $validated['is_done'] ??= false;

        $task = Task::create($validated);
        $this->tasks->prepend($task);

        $this->resetForm();
    }

    // フォームリセット
    public function resetForm()
    {
        $this->reset([
            'title',
            'due_date',
            'is_done',
            'priority',
        ]);

        $this->resetValidation();
    }
};
?>

<div class="max-w-5xl mx-auto">
    <div class="max-w-xl mx-auto text-center">
        <h2 class="text-2xl font-semibold">Task</h2>
        <p class="text-sm text-gray-300 border-t border-gray-400 my-4 py-2">Voltテスト用ページ</p>
    </div>

    <!-- フォーム-->
    <div class="max-w-2xl mx-auto border rounded-xl space-y-4 p-4">
        <h2 class="font-semibold text-lg">入力フォーム</h2>
        <flux:input label="Title" wire:model.live="title" />
        <flux:input label="Due Date" type="date" wire:model="due_date" />
        <flux:checkbox label="Is done?" wire:model="is_done" />
        <flux:select label="Priority" wire:model="priority">
            <option value="">選択して下さい</option>

            @foreach ($priorities as $value => $label)
                <option value="{{ $value }}">
                    {{ $label }}
                </option>
            @endforeach
        </flux:select>

        <flux:button wire:click="save">
            保存
        </flux:button>
    </div>

    <!-- Index -->
    <div class="max-w-2xl mx-auto borer rounded-xl space-y-4 p-4 bg-gray-600 mt-8">
        <h2 class="font-semibold text-lg">Task List</h2>

        @forelse ($tasks as $task)
            <div class="flex justify-between items-center bg-gray-700 rounded-lg p-3">
                <!-- 左側 -->
                <div>
                    <p class="font-semibold text-white">
                        {{ $task->title }}
                    </p>
                    <p class="text-sm text-gray-300">
                        {{ $task->due_date?->format('Y-m-d') ?? '期限なし' }}
                    </p>
                </div>
                <!-- 右側 -->
                <div class="flex items-center gap-3">
                    <span class="
                        text-xs px-2 py-1 rounded-full
                        @if($task->priority === 'high') bg-red-500
                        @elseif($task->priority === 'medium') bg-yellow-500
                        @else bg-green-500
                        @endif
                    ">
                        {{ $priorities[$task->priority] }}
                    </span>

                    @if ($task->is_done)
                        <i class="fa-solid fa-check text-green-400"></i>
                    @else
                        <i class="fa-regular fa-circle text-gray-400"></i>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-300 text-center">
                登録されたタスクはありません。
            </p>
        @endforelse
    </div>
</div>
