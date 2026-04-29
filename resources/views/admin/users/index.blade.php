<x-layout>
    <x-slot:title>Управление пользователями | Админ-панель</x-slot>

        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-8 sm:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-5 mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Пользователи системы</h1>

                    <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
                        <select name="role" class="px-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Все роли</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Пользователи</option>
                            <option value="author" {{ request('role') == 'author' ? 'selected' : '' }}>Авторы</option>
                            <option value="moderator" {{ request('role') == 'moderator' ? 'selected' : '' }}>Модераторы</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Админы</option>
                        </select>
                        <button class="px-5 py-2 text-sm font-medium bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition cursor-pointer">
                            Фильтровать
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Имя / Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Текущая роль</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Статус</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition {{ $user->is_banned ? 'bg-red-50/40' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="text-xs px-2 py-1.5 border border-gray-200 rounded-lg bg-white focus:ring-1 focus:ring-indigo-500">
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="author" {{ $user->role == 'author' ? 'selected' : '' }}>Author</option>
                                            <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        <button class="px-3 py-1.5 text-xs font-medium bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition cursor-pointer">
                                            Сохранить
                                        </button>
                                    </form>
                                </td>

                                <td class="px-6 py-4">
                                    @if($user->is_banned)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        Забанен
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        Активен
                                    </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex gap-2 justify-end">
                                        <form action="{{ route('admin.users.toggleban', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="px-3 py-1.5 text-xs font-medium rounded-lg transition cursor-pointer
                                            {{ $user->is_banned ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-amber-100 text-amber-700 hover:bg-amber-200' }}">
                                                {{ $user->is_banned ? 'Разбанить' : 'Забанить' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Удалить пользователя навсегда?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1.5 text-xs font-medium bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition cursor-pointer">
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
</x-layout>