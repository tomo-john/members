<div class="p-6">
    <div class="overflow-x-auto">
        @if (session()->has('message'))
            <div class="text-green-600 mb-4">
                {{ session('message') }}
            </div>
        @endif
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">アバター</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">名前</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">メールアドレス</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr class="text-black">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/avatar/' . ($user->avatar ?? 'user_default.jpg')) }}" class="w-10">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <!-- 削除ボタン -->
                        <td>
                            <flux:button variant="danger"
                                         wire:click="deleteUser({{ $user->id }})"
                                         wire:confirm.prompt="本当に削除しますか？🐶\n\n削除する場合はDELETEと入力して下さい|DELETE">
                                削除
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
