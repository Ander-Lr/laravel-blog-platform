<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;


class CommentController extends Controller
{

    /**
     * Display a listing of comments.
     */
    public function index()
    {
        $comments = Comment::with('post', 'user')->latest()->paginate(20);
        return view('comments.index', compact('comments'));
    }
    /**
     * Display the specified comment with its related post.
     */
    public function show(string $id)
    {
        // Find the comment or fail
        $comment = Comment::with(['user', 'post.user'])->findOrFail($id);
        return view('comments.show', compact('comment'));
    }

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
    public function edit(string $id)
    {
        $comment = Comment::with('post')->findOrFail($id);
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the comment or fail
        $comment = Comment::findOrFail($id);

        // Base validation for all comments
        $rules = [
            'content' => 'required|string|max:500'
        ];

        // If the comment belongs to a guest, validate name and email
        if ($comment->user_id === null) {
            $rules['guest_name'] = 'required|string|max:100';
            $rules['guest_email'] = 'nullable|email|max:100';
        }

        // Validate request
        $validated = $request->validate($rules);

        // Update comment fields
        $comment->content = $validated['content'];

        // Update guest-only fields
        if ($comment->user_id === null) {
            $comment->guest_name = $validated['guest_name'];
            $comment->guest_email = $validated['guest_email'] ?? null;
        }

        // Save changes
        $comment->save();

        // Redirect back to the comments list with success message
        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Comment updated successfully.');
    }

        /**
     * Remove the specified comment from storage.
     */
    public function destroy(string $id)
    {
        // Find the comment or fail with 404
        $comment = Comment::findOrFail($id);

        // Delete the comment
        $comment->delete();

        // Redirect back to the comments list with a success message
        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }


}
