<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $posts = Post::published()
            ->with(['user', 'category'])
            ->latest('published_at')
            ->paginate(10);

        return view('public.index', compact('posts'));
    }

    public function show(Post $post): View
    {

        if (! $post->isPublished()) {
            $this->authorize('view', $post);
        }

        $post->incrementViews();

        $post->loadCount('comments');

        $post->load(['user', 'category', 'comments' => function ($query) {
            $query->root()->with('user', 'replies.user')->latest();
        }]);

        return view('public.posts.show', compact('post'));
    }

    public function category(Category $category): View
    {
        $posts = $category->posts()
            ->published()
            ->with('user')
            ->latest('published_at')
            ->paginate(10);

        return view('public.index', compact('posts', 'category'));
    }
}
