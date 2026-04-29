<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'IT Блог' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>


<body class="bg-slate-50 font-sans antialiased text-slate-900"
    style="display: flex; flex-direction: column; min-height: 100vh; margin: 0;">
    <nav class="bg-white shadow-sm border-b border-slate-200" style="flex-shrink: 0;">
        <div class="container mx-auto px-4 h-16 flex justify-between items-center">

            <a href="{{ route('posts.index') }}" class="text-2xl font-black text-blue-600 tracking-tighter" style="text-decoration: none;">
                IT-БЛОГ
            </a>

            <div class="flex items-center flex-wrap" style="gap: 25px;">
                @auth
                @can('create', App\Models\Post::class)
                <a href="{{ route('author.posts.create') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition" style="white-space: nowrap; text-decoration: none;">
                    + Написать статью
                </a>
                @endcan

                @can('access-author')
                <a href="{{ route('author.posts.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition" style="white-space: nowrap; text-decoration: none;">
                    Мои статьи
                </a>
                @endcan

                @can('access-moderator')
                <a href="{{ route('moderator.posts.index') }}" class="text-sm font-semibold text-orange-500 hover:text-orange-600 transition" style="white-space: nowrap; text-decoration: none;">
                    Модерация
                </a>
                @endcan

                @can('access-admin')
                <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-rose-600 hover:text-rose-700 transition" style="white-space: nowrap; text-decoration: none;">
                    Админка
                </a>
                @endcan
                @endauth
            </div>

            <div class="flex items-center" style="gap: 20px;">
                @auth
                <div class="flex flex-col items-end leading-none">
                    <span class="text-sm font-bold text-slate-800">Имя: {{ auth()->user()->name }}</span>
                    <span class="text-[10px]  text-slate-400 font-bold mt-1" style="display: block;">
                        Роль: {{ auth()->user()->role }}
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-xs font-bold text-rose-500 hover:bg-rose-50 px-3 py-1.5 rounded border border-rose-100 transition" style="cursor: pointer; white-space: nowrap;">
                        Выйти
                    </button>
                </form>
                @else
                <div class="flex items-center" style="gap: 15px;">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition" style="text-decoration: none;">Вход</a>
                    <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition" style="text-decoration: none; white-space: nowrap;">
                        Регистрация
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    @if(isset($categories) && $categories->count() > 0)
    <div style="max-width: 2500px;  padding: 0 16px; flex-shrink: 0;">
        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div class="category-grid">
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="category-item">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <main style="flex: 1 0 auto;">
        <div class="container mx-auto px-4 py-8">
            @if(session('success'))
            <div class="max-w-4xl mx-auto bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r shadow-sm mb-8">
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
            @endif

            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </div>
    </main>

    <footer style="flex-shrink: 0; background: white; border-top: 1px solid #e2e8f0;  text-align: center; color: #94a3b8;">
        <div class="container mx-auto px-4">
            <p class="text-sm font-medium">&copy; 2026 IT-Блог</p>
        </div>
    </footer>
</body>

</html>