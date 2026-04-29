<x-layout>
    <x-slot:title>{{ $post->title }}</x-slot>

        <article class="max-w-3xl mx-auto bg-white p-4 sm:p-6 md:p-8 rounded-xl shadow-md">
            <header class="border-b border-slate-200 pb-4 sm:pb-6 mb-4 sm:mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-2 sm:mb-3">{{ $post->title }}</h1>
                <div class="flex flex-wrap gap-2 sm:gap-4 text-xs sm:text-sm text-slate-500">
                    <p>
                        Категория:
                        @if($post->category)
                        <a href="{{ route('categories.show', $post->category) }}" class="text-slate-600 hover:text-slate-800 hover:underline transition">
                            {{ $post->category->name }}
                        </a>
                        @else
                        <span class="italic text-slate-400">Без категории</span>
                        @endif
                    </p>
                    <p>Автор: <span class="font-medium text-slate-700">{{ $post->user->name }}</span></p>
                    <p>Дата: {{ $post->published_at?->format('d.m.Y') ?? 'В очереди' }}</p>
                    <p>Просмотров: {{ $post->views_count }}</p>
                </div>
            </header>

            <div class="prose max-w-none text-slate-700 leading-relaxed text-base sm:text-lg mb-8">
                {!! nl2br(e($post->content)) !!}
            </div>

            <hr class="my-6 sm:my-8">

            <section>
                <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-4 sm:mb-6">Комментарии ({{ $post->comments_count }})</h3>

                @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8 bg-slate-50 p-4 sm:p-5 rounded-xl">
                    @csrf
                    <textarea name="content" rows="3" class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-slate-400 focus:border-slate-400" placeholder="Ваш комментарий..."></textarea>
                    <button type="submit" class="mt-3 bg-slate-700 hover:bg-slate-800 text-white px-5 py-2 rounded-lg transition cursor-pointer">
                        Отправить
                    </button>
                </form>
                @else
                <p class="text-slate-500 mb-6">Пожалуйста, <a href="{{ route('login') }}" class="text-slate-600 hover:text-slate-800 hover:underline transition">войдите</a>, чтобы оставить комментарий.</p>
                @endauth

                @foreach($post->comments as $comment)
                @if(is_null($comment->parent_id))
                <div class="border-b border-slate-200 py-4 sm:py-5">
                    <div class="flex flex-wrap justify-between items-start mb-2">
                        <div>
                            <strong class="text-slate-800">{{ $comment->user->name }}</strong>
                            <small class="text-slate-400 ml-2 text-xs sm:text-sm">{{ $comment->created_at->diffForHumans() }} ({{ $comment->created_at->format('d.m.Y H:i:s') }})</small>
                        </div>
                    </div>

                    <p class="text-slate-600 my-2 text-sm sm:text-base">{{ $comment->content }}</p>

                    <div class="flex gap-4 items-center mt-2">
                        @auth
                        <a href="{{ route('comments.reply', $comment) }}"
                            class="bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-800 px-2 py-1 rounded text-xs font-medium no-underline transition">
                            Ответить
                        </a>
                        @endauth

                        @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-700 px-2 py-1 rounded text-xs font-medium border-none cursor-pointer transition">
                                Удалить
                            </button>
                        </form>
                        @endcan

                    </div>

                    @if($comment->replies->count() > 0)
                    <div class="ml-4 sm:ml-8 mt-3 sm:mt-4 border-l-2 border-slate-200 pl-3 sm:pl-5 space-y-3">
                        @foreach($comment->replies as $reply)
                        <div class="py-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <strong class="text-slate-800 text-sm">{{ $reply->user->name }}</strong>
                                <small class="text-slate-400 text-xs">
                                    {{ $reply->created_at->format('d.m.Y H:i:s') }}
                                    <span class="italic">
                                        в ответ <span class="font-medium">{{ $reply->parent->user->name }}</span>
                                        на комментарий от {{ $reply->replyTo->created_at->format('d.m.Y H:i:s') }}
                                    </span>
                                </small>
                            </div>
                            <p class="text-slate-600 text-sm mt-1">{{ $reply->content }}</p>
                            <div class="flex gap-3 mt-1">
                                @auth
                                <a href="{{ route('comments.reply', $reply) }}"
                                    class="bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-800 px-2 py-1 rounded text-[10px] sm:text-xs font-medium no-underline transition">
                                    Ответить
                                </a>
                                @endauth

                                @can('delete', $reply)
                                <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-700 px-2 py-1 rounded text-[10px] sm:text-xs font-medium border-none cursor-pointer transition">
                                        Удалить
                                    </button>
                                </form>
                                @endcan

                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif
                @endforeach
            </section>
        </article>
</x-layout>