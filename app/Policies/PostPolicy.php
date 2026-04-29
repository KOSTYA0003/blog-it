<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function create(User $user): bool
    {
        return in_array($user->role, ['author', 'moderator', 'admin']);
    }

    public function view(?User $user, Post $post): bool
    {
        if ($post->isPublished()) {
            return true;
        }

        if (! $user) {
            return false;
        }

        return $user->id === $post->user_id || $user->isModerator() || $user->isAdmin();
    }

    public function update(User $user, Post $post): bool
    {
        if ($user->isModerator()) {
            return true;
        }

        return $user->id === $post->user_id && in_array($post->status, ['draft', 'rejected', 'published']);
    }

    public function submit(User $user, Post $post): bool
    {
        return $user->id === $post->user_id && in_array($post->status, ['draft', 'rejected']);
    }

    public function moderate(User $user): bool
    {
        return $user->isModerator();
    }

    public function delete(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $post->user_id && $post->status === 'draft';
    }
}
