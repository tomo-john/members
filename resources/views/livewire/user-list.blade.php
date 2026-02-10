<div class="p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">アバター</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">名前</th>
                    <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">メールアドレス</th>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
