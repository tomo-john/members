<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sandbox;

class SandboxController extends Controller
{
    public function index ()
    {
        return view('sandbox');
    }

    public function store(Request $request)
    {
        // 全データを見る🐶
        // dd($request->all());

        // validation
        $inputs = $request->validate([
            'name' => 'required|max:255',
            'scheduled_at' => 'nullable|date',
        ]);

        // 保存
        Sandbox::create($inputs);

        // 元の画面に戻る
        return back()->with('message', '保存しました🐶');
    }

}
