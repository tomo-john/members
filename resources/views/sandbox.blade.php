<x-layouts::app>
    <h1>Hello 🐶</h1>
    <a href="{{ route('home') }}">HOME</a>
    <i class="fa-solid fa-dog"></i>
    <flux:input
        type="date"
        label="日付を選択"
        name="published_at"
        view="calendar" {{-- カレンダーアイコンを表示 --}}
    />
</x-layouts::app>
