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

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = auth()->id(); // Associa il post all'utente loggato
        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post created successfully!'); // Modifica se necessario
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        // Reindirizza alla dashboard con un messaggio di successo
        return redirect()->route('dashboard')->with('success', 'Post successfully deleted!');
    }

}
