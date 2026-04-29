<x-layout>
    <x-slot:title>Создание новой статьи</x-slot>

        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Новая публикация</h1>

            <form action="{{ route('author.posts.store') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block font-semibold text-slate-700 mb-2">Заголовок статьи</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block font-semibold text-slate-700 mb-2">Категория</label>
                    <select name="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Выберите категорию...</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block font-semibold text-slate-700 mb-2">Краткое описание (для списка)</label>
                    <textarea name="excerpt" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block font-semibold text-slate-700 mb-2">Текст статьи</label>
                    <textarea name="content" rows="10"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('content') }}</textarea>
                    @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4 items-center">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg transition cursor-pointer">
                        Сохранить черновик
                    </button>
                    <a href="{{ route('author.posts.index') }}" class="text-gray-500 hover:text-gray-700 transition">Отмена</a>
                </div>
            </form>
        </div>
</x-layout>