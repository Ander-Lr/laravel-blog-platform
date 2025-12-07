<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller{
    /**
     * Display a listing of the resource.
     */
    public function home(){
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function index(){
        $posts = Post::latest()->paginate(10);
        return view('index', compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable    '
        ]);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $data['user_id'] = auth()->id();
        Post::create($data);
        return redirect()->route('home');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post) {
        $post->load('comments.user');
        return view('posts.show', compact('post'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validate incoming form data
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|string|max:255'
        ]);

        // Update post fields
        $post->update($data);

        // Redirect back to posts list with success message
        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post){
        // Delete all comments associated with this post
        $post->comments()->delete();
        // Delete the post itself
        $post->delete();
        // Redirect back to the posts list with a success message
        return redirect()->route('posts.index')
            ->with('success', 'Post and related comments successfully deleted.');
    }


}
