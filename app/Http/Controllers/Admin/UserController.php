<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validate input fields
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,editor,lector',
        ]);

        // Create the user
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']), // Hash password
            'role'     => $validated['role'],
        ]);

        // Redirect with success message
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the user by ID or fail with 404
        $user = User::findOrFail($id);

        // Return the user details view
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find user by ID or throw 404 if not found
        $user = User::findOrFail($id);

        // Return edit view with the user data
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the user or return 404
        $user = User::findOrFail($id);

        // Validate input fields
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,editor,lector',
            'password' => 'nullable|min(6)', // Only update if provided
        ]);

        // Update base fields
        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];

        // Update password only if provided
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        // Save changes to the database
        $user->save();

        // Redirect with success message
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find user or fail with 404
        $user = User::findOrFail($id);

        // Delete all comments written by this user
        // (guest comments remain untouched)
        $user->comments()->delete();

        // Delete posts created by this user and their related comments
        foreach ($user->posts as $post) {
            // Delete comments belonging to the post
            $post->comments()->delete();

            // Delete the post itself
            $post->delete();
        }

        // Finally delete the user
        $user->delete();

        // Redirect back with success message
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

}
