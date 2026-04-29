<x-layout>
    <div class="max-w-2xl mx-auto py-10">

        <h2 class="text-2xl font-bold mt-6 mb-4">Ваш ответ пользователю {{ $reply->user->name }}</h2>
        <p class="text-slate-500 text-sm mb-2">на коммент от {{ $reply->created_at->format('d.m.Y H:i:s') }}</p>
        <div class="bg-slate-100 p-4 rounded-lg mb-6 italic text-slate-600 border-l-4 border-indigo-400">
            "{{ $reply->content }}"
        </div>

        <form action="{{ route('comments.store', $post) }}" method="POST" class="bg-white p-6 rounded-xl border shadow-sm">
            @csrf
            <input type="hidden" name="reply_id" value="{{ $reply->id }}">
            <input type="hidden" name="reply_date" value="{{ $reply->created_at->format('d.m.Y H:i') }}">

            <textarea name="content" rows="4" required class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Напишите ваш ответ...">{{ $reply->user->name }},</textarea>

            <button class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2 rounded-lg font-bold transition cursor-pointer">
                Отправить ответ
            </button>
        </form>
    </div>
</x-layout>