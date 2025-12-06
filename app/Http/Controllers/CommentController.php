<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post){
        $rules = ['content' => 'required'];

        if (!auth()->check()) {
            $rules['guest_name'] = 'required';
            $rules['guest_email'] = 'nullable|email';
        }

        $data = $request->validate($rules);
        $data['post_id'] = $post->id;

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        Comment::create($data);

        return back()->with('status', 'Comentario publicado');
    }

}
