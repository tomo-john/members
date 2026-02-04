# fluxのオーバーライド

fluxはLivewireで使うために作られた使いやすいUIコンポーネントライブラリ。

デフォルトのデザインを変えてみる。

flux関連のファイルは、`vendor`ディレクトリの中に入っている。

`flux:button`のスタイルなら => `vendor/livewire/flux/stubs/resources/views/flux/button`

でも`vendor`は編集してはいけない🐶

## fluxのオーバーライド

```bash
php artisan flux:publish
```

どのコンポーネントにするか聞かれるので今回は`Button`を選択。

=> `resources/views/flux/button/`が生成される

試しに、`resources/views/flux/button/index.blade.php`を編集(primaryの色変える)

```php
<?php
    // 省略
    ->add(match ($variant) { // Background color...
        'primary' => 'bg-pink-500 hover:bg-pink-600',
        // 'primary' => 'bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)]',
```

