# コメント機能の追加

## モデルとマイグレーションファイル

```bash
php artisan make:model Comment -m
```

`マイグレーションファイル`:

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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // constrained() をつけることで、相手のテーブルが削除された時の挙動も制御🐶
            // cascadeOnDelete() は、投稿が消えたらコメントも一緒に消す設定🐶
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('body');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
```

`Commentモデル`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'body',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

## リレーションの設定(PostとUser)

下記のリレーション設定を追加:

```php
<?php
public function comments() {
    return $this->hasMany(Comment::class);
}
```

## Livewireコンポーネントの作成

```bash
php artisan make:livewire CommentSection --class
```

