<x-layout>
    <x-slot:title>Причина отказа | {{ $post->title }}</x-slot>

        <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
            <h2 class="text-xl font-bold text-red-700 mb-2">Отклонение статьи</h2>
            <p class="text-slate-600 mb-6">
                Вы отклоняете статью: <strong class="text-slate-800">{{ $post->title }}</strong>
            </p>

            <form action="{{ route('moderator.posts.reject', $post) }}" method="POST">
                @csrf
                @method('PATCH')

                <label class="block font-semibold text-slate-700 mb-2">Укажите причину для автора:</label>
                <textarea name="comment" required
                    class="w-full h-32 p-3 border border-red-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 mb-6"
                    placeholder="Например: добавьте больше примеров кода или исправьте ошибки в первом абзаце..."></textarea>

                <div class="flex gap-4 items-center">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 rounded-xl transition cursor-pointer">
                        Подтвердить отказ
                    </button>
                    <a href="{{ route('moderator.posts.index') }}" class="text-slate-500 hover:text-slate-700 transition no-underline">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
</x-layout>