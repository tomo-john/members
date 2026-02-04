<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;

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
        $validated = $this->validate([
            'body' => 'required|max:1000',
        ]);

        $comment = new Comment();
        $comment->body = $validated['body'];
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $this->post->id;
        $comment->save();

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
