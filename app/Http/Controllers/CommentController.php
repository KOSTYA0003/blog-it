<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function reply(Comment $comment)
    {
        return view('public.comments.reply', [
            'reply' => $comment,
            'post' => $comment->post,
        ]);
    }

    public function store(StoreCommentRequest $request, Post $post)
    {
        if (! $post->isPublished()) {
            abort(404);
        }

        $originalParentId = $request['reply_id'] ?? null;

        $finalParentId = $originalParentId;

        $replyToId = $originalParentId;

        if ($originalParentId) {

            $parentComment = Comment::findOrFail($originalParentId);

            if ($parentComment->parent_id) {
                $finalParentId = $parentComment->parent_id;
            }
        }

        Auth::user()->comments()->create([
            'post_id' => $post->id,
            'parent_id' => $finalParentId,
            'reply_to_id' => $replyToId,
            'content' => $request->validated()['content'],
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Ответ успешно добавлен!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('success', 'Комментарий удален.');
    }
}
