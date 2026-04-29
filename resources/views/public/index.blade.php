<x-layout>
    <x-slot:title>Главная страница | IT Блог</x-slot>

        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-slate-800 mb-8">Последние статьи</h1>

            @forelse($posts as $post)
            <article class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6 hover:shadow-md transition">
                <div class="flex flex-wrap gap-3 text-sm text-slate-500 mb-2">
                    <span>{{ $post->published_at->format('d.m.Y') }}</span>
                    <span>•</span>
                    @if($post->category)
                    <a href="{{ route('categories.show', $post->category) }}"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 hover:bg-indigo-200 transition-colors">
                        {{ $post->category->name }}
                    </a>
                    @else
                    <span class="italic text-slate-400">Без категории</span>
                    @endif
                </div>

                <h2 class="text-xl font-bold text-slate-800 mb-2">
                    <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-600 transition no-underline text-inherit">
                        {{ $post->title }}
                    </a>
                </h2>

                <p class="text-slate-600 mb-3">{{ $post->excerpt }}</p>

                <div class="text-sm text-slate-500">
                    <strong>Автор:</strong> {{ $post->user->name }}
                </div>
            </article>
            @empty
            <p class="text-center text-slate-400 py-12">Статей пока нет.</p>
            @endforelse

            <div class="mt-8 [&_p]:hidden">
                {{ $posts->links() }}
            </div>

        </div>
</x-layout>