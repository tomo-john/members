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
        dd($request->all());
    }

}
