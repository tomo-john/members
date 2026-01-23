# Dog

Livewire(Volt)検証用🐶

## モデル&テーブル

```bash
php artisan make:model Dog -m
```

```php
<?php
// dogs table
$table->string('name');
$table->date('birthday')->nullable();
$table->boolean('is_good_boy')->default(true);
```

## Livewire(Volt)作成

```bash
php artisan make:livewire dog-manager
```

Vole有効ならbladeだけ作成される(`resources/views/components/⚡dog-manager.blade.php`)

## 構成メモ

```bash
Route::view('/dogs', 'dogs')
        ↓
dogs.blade.php
        ↓
<livewire:dog-manager />
        ↓
dog-manager.blade.php
（状態 + 処理 + View）
```

