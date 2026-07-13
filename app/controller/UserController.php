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
     * Save a user (Insert or Update).
     */
    public function save(Request $request)
    {
        $id = $request->input('editId');
        
        $rules = [
            'name' => 'required|min:3|max:50',
            'email' => $id ? "required|email|unique:users,email,{$id}" : 'required|email|unique:users,email'
        ];
        
        $validated = $request->validate($rules);
        
        if ($id) {
            db('users')->where('id', $id)->update([
                'name' => $validated['name'],
                'email' => $validated['email']
            ]);
            session()->flash('success', 'User updated successfully!');
        } else {
            db('users')->insert([
                'name' => $validated['name'],
                'email' => $validated['email']
            ]);
            session()->flash('success', 'User added successfully!');
        }

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
