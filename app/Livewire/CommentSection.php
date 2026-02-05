<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

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
