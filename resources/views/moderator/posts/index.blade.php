<x-layout>
    <x-slot:title>Очередь проверки | Модерация</x-slot>

        <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Статьи на модерации</h1>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-left border-b-2 border-slate-200">
                            <th class="px-4 py-4 font-semibold text-slate-700">Статья и Автор</th>
                            <th class="px-4 py-4 font-semibold text-slate-700">Подано</th>
                            <th class="px-4 py-4 font-semibold text-slate-700 text-center">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-4 py-4">
                                <a href="{{ route('posts.show', $post) }}" target="_blank" class="font-semibold text-blue-600 hover:text-blue-800 no-underline">
                                    {{ $post->title }}
                                </a>
                                <div class="text-xs text-slate-500 mt-1">
                                    Автор: <strong class="text-slate-700">{{ $post->user->name }}</strong>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-slate-600 text-sm">
                                {{ $post->updated_at->diffForHumans() }}
                            </td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex gap-2 justify-end flex-wrap">
                                    <a href="{{ route('author.posts.edit', $post) }}"
                                        class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-4 py-2 rounded-lg text-sm font-medium no-underline transition">
                                        Редактировать
                                    </a>


                                    <form action="{{ route('moderator.posts.approve', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-green-100 text-green-700 hover:bg-green-200 px-4 py-2 rounded-lg text-sm font-medium transition cursor-pointer">
                                            Одобрить
                                        </button>
                                    </form>

                                    <a href="{{ route('moderator.posts.reject.form', $post) }}"
                                        class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-sm font-medium no-underline transition">
                                        Отклонить
                                    </a>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-12 text-center text-slate-400">
                                Очередь пуста.
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