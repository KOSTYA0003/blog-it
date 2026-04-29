<x-layout>
    <x-slot:title>Мои статьи | Панель автора</x-slot>

        <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-md">
            <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Мои публикации</h1>

                <form action="{{ route('author.posts.index') }}" method="GET" class="flex gap-2">
                    <select name="status"
                        class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Все статусы</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Отклонено</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновик</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>На проверке</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Опубликовано</option>
                    </select>
                    <button class="px-4 py-1.5 text-sm bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition cursor-pointer">
                        Фильтровать
                    </button>
                </form>

                <a href="{{ route('author.posts.create') }}"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg font-medium transition no-underline">
                    + Создать статью
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200 text-left">
                            <th class="px-4 py-3 font-semibold text-slate-700">Заголовок</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Статус</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Дата</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                <strong class="text-slate-800">{{ $post->title }}</strong>
                                <br>
                                <small class="text-slate-400 text-sm">Категория: {{ $post->category->name }}</small>
                            </td>
                            <td class="px-4 py-3">
                                @if($post->status === 'published')
                                <span class="text-emerald-600 font-medium">● Опубликовано</span>
                                @elseif($post->status === 'pending')
                                <span class="text-amber-500 font-medium">● На проверке</span>
                                @elseif($post->status === 'rejected')
                                <span class="text-red-500 font-medium">● Отклонено</span>
                                <br><small class="text-slate-400 text-xs" title="{{ $post->moderator_comment }}">Замечание модератора</small>
                                @else
                                <span class="text-slate-400 font-medium">● Черновик</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-500">
                                {{ $post->created_at->format('d.m.Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-3 items-center">
                                    @can('update', $post)
                                    <a href="{{ route('author.posts.edit', $post) }}"
                                        class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-4 py-2 rounded-lg text-sm font-medium no-underline transition inline-block">
                                        Правка
                                    </a>

                                    @endcan

                                    @if(in_array($post->status, ['draft', 'rejected']))
                                    @can('submit', $post)
                                    <form action="{{ route('author.posts.submit', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="bg-amber-50 text-amber-600 hover:bg-amber-100 px-4 py-2 rounded-lg text-sm font-medium transition cursor-pointer border-none">
                                            Отправить на модерацию
                                        </button>

                                    </form>
                                    @endcan
                                    @endif

                                    @can('delete', $post)
                                    <form action="{{ route('author.posts.destroy', $post) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Удалить статью?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-medium transition cursor-pointer border-none">
                                            Удалить
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                                У вас пока нет ни одной статьи.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
</x-layout>