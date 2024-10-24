<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Crea il post associandolo all'utente autenticato
        Auth::user()->posts()->create($request->all());

        return redirect()->route('dashboard')->with('success', 'Post creato con successo!');
    }
}
