@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ asset('logo/test_logo.jpg') }}" alt="犬のイラスト" class="w-full max-w-md mx-auto rounded shadow-lg"><br>
            @if (trim($slot) === 'Laravel')
                <img src="https://laravel.com/img/notification-logo-v2.1.png" class="logo" alt="Laravel Logo">
            @else
                {!! $slot !!}
            @endif
        </a>
    </td>
</tr>
