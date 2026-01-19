<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|max:1000',
            'image' => 'image|max:1024',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;

        // 画像保存用処理
        if (request('image')) {
            $original = request()->file('image')->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original;
            request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        $post->save();

        return redirect()->route('post.create')->with('message', '投稿を作成しました');
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }
}
