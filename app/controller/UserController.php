<?php

namespace App\Controller;

use Kite\Core\Request;

class UserController
{
    /**
     * Show the users list and add form.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = db('users');
        
        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }
        
        $users = $query->orderBy('id', 'DESC')->paginate(5);
        return view('users', ['users' => $users, 'editUser' => null, 'search' => $search]);
    }

    /**
     * Show the users list and edit form.
     */
    public function edit(Request $request, $id)
    {
        $search = $request->input('search');
        $query = db('users');
        
        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }
        
        $users = $query->orderBy('id', 'DESC')->paginate(5);
        $editUser = db('users')->where('id', $id)->first();
        
        if (!$editUser) {
            session()->flash('error', 'User not found!');
            return redirect(route('users.index'));
        }

        return view('users', ['users' => $users, 'editUser' => $editUser, 'search' => $search]);
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email'
        ]);
        
        db('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);
        
        session()->flash('success', 'User added successfully!');

        return redirect(route('users.index'));
    }

    /**
     * Update an existing user.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => "required|email|unique:users,email,{$id}"
        ]);
        
        db('users')->where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);
        
        session()->flash('success', 'User updated successfully!');

        return redirect(route('users.index'));
    }

    /**
     * Delete an existing user.
     */
    public function destroy(Request $request, $id)
    {
        db('users')->where('id', $id)->delete();
        session()->flash('success', 'User deleted successfully!');
        return redirect(route('users.index'));
    }
}
