<x-layouts::auth>
    <div class="mt-4 flex flex-col gap-6">
        <flux:text class="text-center">
            ご登録ありがとうございます🐶
            お手数ですが、メールアドレスの確認をさせて下さい。下記ボタンをクリックして下さいね🐶
        </flux:text>

        @if (session('status') == 'verification-link-sent')
            <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </flux:text>
        @endif

        <div class="flex flex-col items-center justify-between space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <flux:button type="submit" variant="primary" class="w-full">
                    <i class="fa-solid fa-dog mx-1"></i>
                    認証
                    <i class="fa-solid fa-dog mx-1"></i>
                </flux:button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button variant="ghost" type="submit" class="text-sm cursor-pointer" data-test="logout-button">
                    {{ __('Log out') }}
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::auth>
