<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('moderate', Post::class);

        $posts = Post::pending()
            ->with(['user', 'category'])
            ->latest()
            ->paginate(20);

        return view('moderator.posts.index', compact('posts'));
    }

    public function approve(Post $post)
    {
        $this->authorize('moderate', Post::class);

        $post->status = 'published';
        $post->published_at = now();
        $post->moderator_comment = null;
        $post->save();

        return back()->with('success', 'Статья одобрена');
    }

    public function rejectForm(Post $post)
    {
        $this->authorize('moderate', Post::class);

        return view('moderator.posts.reject', compact('post'));
    }

    public function reject(Request $request, Post $post)
    {

        $this->authorize('moderate', Post::class);

        $validated = $request->validate([
            'comment' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        $post->moderator_comment = $validated['comment'];
        $post->status = 'rejected';
        $post->save();

        return back()->with('warning', 'Статья отклонена');
    }
}
