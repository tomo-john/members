<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * index
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * show
     */
    public function view(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * create
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * edit / update
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id == $post->user_id;
    }

    /**
     * destroy
     */
    public function delete(User $user, Post $post): bool
    {
        // 作成者は削除可能
        if ($user->id == $post->user_id) {
            return true;
        }

        // 管理者は削除可能
        foreach ($user->roles as $role) {
            if ($role->name == 'admin') {
                return true;
            }
        }

        // その他の場合、削除不可能
        return false;
    }

    /**
     * ソフトデリート(一時的に削除)されたレコードをDBに復元する権限を定義
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * ソフトデリートされたレコードをDBから完全に削除する権限を定義
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
