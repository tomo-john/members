<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" conten="ie=edge">
        <title>あなたの投稿にコメントがありました🐶</title>
    </head>

    <body>
        ----
        <p>コメント: {{ $inputs['body'] }}</p>
        ----
        <p>コメントに返信するには、サイトにログインして<a href="{{ route('post.show', $post) }}">こちら</a>の投稿をご確認下さい。</p>
    </body>
</html>
