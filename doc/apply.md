# @apply

Tailwindでよく使用するクラスのグループは登録しておくことができる。

`resources/css/app.css`の一番下に下記を追加。

```css
.btnsetb {
    @apply px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors;
}

.btnsetr {
    @apply px-6 py-3 bg-red-600 text-white rounded hover:bg-red-700 transition-colors;
}

.btnset {
    @apply px-6 py-3 text-white rounded transition-colors;
}
```

Blade側での呼び出し方は`class`に指定するだけ。

```blade
@guest
    <a href="{{ route('login') }}" class="btnsetb">
        ログイン
    </a>
    <a href="{{ route('register') }}" class="btnsetr">
        登録する
    </a>
@endguest
<a href="#" class="btnset bg-green-600 hover:bg-green-700">
    ダミー
</a>
```

