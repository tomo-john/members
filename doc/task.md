# Task (LivewireでCRUD)

## モデル&マイグレーション

```bash
php artisan make:model Task -m
```

```php
<?php
// 追記箇所 (今回のテーブル)
$table->string('title');
$table->date('due_date')->nullable;
$table->boolean('is_done')->default(false);
$table->string('priority')->default('middle');
```

## モデル

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'due_date',
        'is_done',
        'priority',
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_done' => 'boolean',
    ];
}
```

- `$fillable`: 一括代入の安全装置
- `$casts`: DB, PHPの型変換ルール

## Livewire(Volt)作成

```bash
php artisan make:livewire Task
```

