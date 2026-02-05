# mailable(メイラブル)

- 1. Livewireでコメント保存を行う際、メールを送信処理を行う。送信メールの処理はMailableに引き渡す。
- 2. 新規Mailableクラスを作成し、送信メールを設定する。送信メールの内容はビューファイルを参照することにする。
- 3. ビューファイルに送信メールの内容を記述する。

## メール送信の処理

<details>
<summary>`app/Livewire/CommentSection.php`に追記</summary>

```php
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContacForm;

class CommentSection extends Component
{
    public $post;
    public $body = '';
    public $comments;

    public function mount()
    {
        $this->getComments();
    }

    public function save()
    {
        // バリデーション
        $validated = $this->validate([
            'body' => 'required|max:1000',
        ]);

        // コメント作成
        $comment = Comment::create([
            'body' => $validated['body'],
            'user_id' => auth()->user()->id,
            'post_id' => $this->post->id,
        ]);

        // メール送信
        $postUser = $comment->post->user->email;
        $post = $this->post;
        if ($postUser != auth()->user()->email) {
            Mail::to($postUser)->send(new ContactForm($validated, $post));
        }

        $this->reset('body');
        $this->getComments();
        session()->flash('message', 'コメントが送信されました');
    }

    public function getComments()
    {
        $this->comments = $this->post->comments()->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}
```

</details>

`use Illuminate\Support\Facades\Mail;`でメールファザードを使用。

`Mail::to()`: Mailファザードのtoメソッドで`$post`の投稿者本人にメール送信。

=> コメント本文(`$validated`)と投稿データ(`$post`)を渡す

`ContactForm`に処理が受け渡されるので、次に作成する。

## Mailableの作成

ContactFormという名前の新規Mailableクラスを作成:

```bash
php artisan make:mail ContactForm
```

app/Mailの中にContactForm.phpファイルができるので編集:

<details>
<summary>`app/Mail/ContactForm.php`</summary>

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $inputs;
    public $post;

    public function __construct($inputs, $post)
    {
        $this->inputs = $inputs;
        $this->post = $post;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'コメントがありました🐶',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with:[
                'inputs' => $this->inputs,
                'post' => $this->post,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
```

</details>

コントローラ(Livewire)側から渡される引数を`__construct`メソッドで受け取り定義。

- `envelopメソッド` : 件名や送信者情報
- `contentメソッド` : メールの中身となるビューファイルの場所を指定
- `attachmentsメソッド` : 添付ファイルを設定(今回は使用しない)

メール中身のビューファイルは今回は`resources/views/emails/contact.blade.php`とする。

Laravel公式では`resources/views/emails`ディレクトリに置くことを推奨。

<details>
<summary>`resources/views/emails/contact.blade.php`</summary>

```blade
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
```

</details>
