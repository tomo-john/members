@props(['message'])

@if ($message)
    @php
        $classes = 'border px-4 py-3 rounded relative bg-green-100 border-green-400 text-green-700';
    @endphp

    <div class="{{ $classes }}">
        {{ $message }}
    </div>
@endif
