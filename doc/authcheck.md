# Authcheckメソッド

- `Auth::check()`: ユーザーがログインしている場合に`true`を返す
- `!Auth::check()`: ユーザーがログインしていない場合に`true`を返す

# @guest

`@guest` ～ `@endguest`で囲んだ箇所は、ゲストである(ログインしていない)場合のみ表示される。

