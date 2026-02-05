# Policy

Postモデル用のPolicyを作成:

```bash
php artisan make:policy PostPolicy --model=Post
```

ポリシーの名前は`モデル名+Policy`で作成する。(`PostPolicy`)

この命名規則に従わない場合、ポリシー検出の登録が必要。([ポリシーの検出](https://readouble.com/laravel/12.x/ja/authorization.html))


<details>
<summary>生成された`app/Policies/PostPolicy.php`を編集</summary>

```php
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
```

</details>

<details>
<summary>コントローラ側の記載(edit, update, delete)</summary>

```php
<?php
public function edit(Post $post)
{
    Gate::authorize('update', $post);
    return view('post.edit', compact('post'));
}

public function update(Request $request, Post $post)
{
    Gate::authorize('update', $post);
    $inputs = $request->validate([
        'title' => 'required|max:255',
        // ...略
}

public function destroy(Post $post)
{
    Gate::authorize('delete', $post);
    $post->delete();
    return redirect()->route('post.index')->with('message', '投稿を削除しました');
}
```

</details>

## Policyでビューに制限をかける

```blade
<!-- Policyで表示制限 -->
@can('update', $post)
    <a href="{{ route('post.edit', $post) }}">
        <flux:button class="bg-teal-700">編集</flux:button>
    </a>
@endcan

@can('delete', $post)
    <form method="post" action="{{ route('post.destroy', $post) }}">
        @csrf
        @method('delete')
        <flux:button variant="danger" class="bg-red-700" type="submit" onClick="return confirm('本当に削除しますか？🐶');">削除</flux:button>
    </form>
@endcan
```

## GateとPolicy

- Gate: シンプルで使いやすい
- Policy: モデルごとに制限をかける

### Gate

特定のモデル(データ)に依存しない、システム全体の機能を縛るのに適している。

=> 管理画面に入れるか？システム設定の変更はできるか？など

`app/Providers/AppServiceProvider.php`などに手軽に実装可能。

### Policy

PostやUserなんどのモデル単位で誰がどう操作できるかを制限する。

モデルごとに独立したファイル(`PostPolicy.php`など)を作り定義する。

