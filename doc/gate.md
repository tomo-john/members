# Gate

- Gate: モデルには直接関係ないけど、この機能は許可された人だけ
- Policy: 特定もモデルに対して、誰が何をできるのかを定義

[Gate公式マニュアル](https://readouble.com/laravel/12.x/ja/authorization.html)

## Gateの設定(投稿者本人)

`app/Providers/AppServiceProvider.php`

```php
<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
// Gate使う
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        // 投稿本人かどうかを判定
        Gate::define('post-owner', function ($user, $post) {
            return $user->id === $post->user_id;
        });
    }
```

`boot()`メソッドに`Gate::define`を追加。

`post-owner`はGateの名前。

定義したこのGateをControllerで使ってみる:

```php
<?php
// use宣言の追加を忘れない
use Illuminate\Support\Facades\Gate;

    public function edit(Post $post)
    {
        Gate::authorize('post-owner', $post);
        return view('post.edit', compact('post'));
    }
```

引数には`$post`を指定。`$user`はログインしているユーザーが自動で入る。

## Gateの設定(管理者用)

`app/Providers/AppServiceProvider.php`の`boot()`に追加:

```php
<?php
    public function boot(): void
    {
        $this->configureDefaults();

        // 投稿本人かどうかを判定
        Gate::define('post-owner', function ($user, $post) {
            return $user->id === $post->user_id;
        });

        // 管理者かどうかを判定
        Gate::define('admin', function ($user) {
            foreach($user->roles as $role) {
                if($role->name == 'admin') {
                    return true;
                }
            }
            return false;
        });
    }
```

コントローラ側では、複数のGateを設定してみる:

```php
<?php
public function destroy(Post $post)
{
    if (Gate::any(['post-owner', 'admin'], $post)) {
        $post->delete();
        return redirect()->route('post.index')->with('message', '投稿を削除しました');
    } else {
        abort('403', 'Unauthorized action 🐶');
    }
}
```

投稿者本人か管理者(`role = admin`)は削除が可能。

## Blade側の制限

```blade
<div class="flex justify-end  gap-4 my-2">
    @can('post-owner', $post)
        <a href="{{ route('post.edit', $post) }}">
            <flux:button class="bg-teal-700">編集</flux:button>
        </a>
    @endcan

    @canany(['post-owner', 'admin'], $post)
        <form method="post" action="{{ route('post.destroy', $post) }}">
            @csrf
            @method('delete')
            <flux:button variant="danger" class="bg-red-700" type="submit" onClick="return confirm('本当に削除しますか？🐶');">削除</flux:button>
        </form>
    @endcanany
</div>
```

- `@can`: 指定した権限がある場合に表示
- `@canany`: 指定した権限のうち1つを持っていれば表示
- `@cannot`: 指定した権限を持っていない場合に表示

## ミドルウェアで制限をかける

```php
<?php
Route::middleware(['can:Gateの名前, (引数)'])->group(function(){
    ルート設定;
});
```

```php
<?php
Route::resource('post', PostController::class);
// ミドルウェアによるGate制限
Route::resource('post', PostController::class)
    ->only(['edit', 'update'])
    ->middleware('can:post-owner,post');
```

