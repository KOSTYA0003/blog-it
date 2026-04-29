<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Auth::user()->posts();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

        return view('author.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('author.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $post = Auth::user()->posts()->make($data);

        $post->slug = Str::slug($data['title']).'-'.now()->timestamp;
        $post->status = 'draft';

        $post->save();

        return redirect()->route('author.posts.index')
            ->with('success', 'Статья создана как черновик!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::all();

        return view('author.posts.edit', compact('post', 'categories'));
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();

        $post->fill($data);

        if ($post->isDirty('title')) {
            $post->slug = Str::slug($post->title).'-'.now()->timestamp;
        }

        $post->status = 'draft';

        $post->save();

        return redirect()->route('author.posts.index')
            ->with('success', 'Статья успешно обновлена!');
    }

    public function submit(Post $post)
    {
        $this->authorize('submit', $post);

        $post->status = 'pending';
        $post->save();

        return back()->with('success', 'Статья отправлена на модерацию модераторам.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back()->with('success', 'Статья удалена.');
    }
}
