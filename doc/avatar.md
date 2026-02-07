# Avatar

アバター作成🐶

## アバター用カラムを追加

```bash
php artisan make:migration add_column_avatar_to_user_table --table=users
```


<details>
<summary>マイグレーションファイル</summary>

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->default('user_default.jpg')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }
};
```

デフォルトで使用されるアバター名(`user_default.jpg`)も設定。

`storage/app/public/avatar`に`user_default.jpg`を置いておく。

(シンボリックリンクは設置済み。)

`public`からアクセスする場合は、`public/storage/avatar`

</details>

## Userモデルのfillableに追加したカラムを追加

`app/Models/User.php`

```php
<?php
protected $fillable = [
    'name',
    'email',
    'avatar',
    'password',
];
```

=> よく忘れるやつ🐶

## User登録用コントローラの修正

<details>
<summary>`app/Actions/Fortify/CreateNewUser.php`</summary>

```php
<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\Rule;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */

    /** 元のコード
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
    }
     */

    // 作り直し
    public function create(array $input): User
    {
        // 1. バリデーション実行
        // 成功すると、ルールに定義した項目だけが $validated に入る
        $validated = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
            'avatar' => ['nullable', 'image', 'max:1024'],
        ])->validate();

        // 2. ユーザーデータの準備（ハッシュ化などは自動または手動で確認してね）
        $userData = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'], // Fortifyが自動でハッシュ化しない設定なら Hash::make() が必要
        ];

        // 3. アバター処理
        // バリデーション後の $validated['avatar'] を使うのが安全！
        if (isset($input['avatar'])) {
            $timestamp = now()->format('YmdHis');
            $originalName = $input['avatar']->getClientOriginalName();
            $filename = $timestamp . '_' . $originalName;

            $input['avatar']->storeAs('avatar', $filename, 'public');
            $userData['avatar'] = $filename;
        }

        // ユーザーを作成
        $user = User::create($userData);
        $user->roles()->attach(2);

        return $user;
    }
}
```

</details>


## User登録フォームにアバター追加

<details>
<summary>`resources/views/pages/auth/register.blade.php`</summary>

```blade
<!-- formタグにenctypeを追加 -->
<form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6" enctype="multipart/form-data">

<!-- flux:inputにavatar追加 -->
<flux:input
    id="avatar"
    name="avatar"
    type="file"
/>
```

</details>

