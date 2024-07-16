<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
    if(auth()->user()->user_type == 'Admin')
    {

        if ($request->ajax()) {
            $users = User::latest()->get();
            return response()->json(['users' => $users, 'status' => 'success'], 200);
        }
        return view('users');
    }
        return abort(403, 'Access denied');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:25',
            'last_name' => 'required|string|max:25',
            'email' => 'required|email|max:50|unique:users',
            'user_type' => 'required|string',
            'password' => 'required|confirmed|string|max:25|min:5',
            'password_confirmation' => 'required|string',
        ]);

        $created = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'user_type' => $validated['user_type'],
            'password' => Hash::make($validated['password']),
            'show_password' => $validated['password'],
        ]);

        if ($created) {
            $users = User::latest()->get();
            return response()->json(['message' => 'New User ' . $created->first_name . ' Added successfully!', 'status' => 'success', 'title' => 'Added', 'users' => $users], 201);
        }

        return response()->json(['message' => 'Failed to add new user ' . $created->first_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }

    public function update(User $user, Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:25',
            'last_name' => 'required|string|max:25',
            'email' => 'required|email|max:50|unique:users,email,' . $user->id,
            'user_type' => 'required|string',
            'password' => 'required|confirmed|string|max:25|min:5',
            'password_confirmation' => 'required|string',
        ]);

        $validated['password'] = Hash::make($request->password);
        $updated = $user->update($validated);

        if ($updated) {

            if ($user->getChanges()) {
                $users = User::latest()->get();
                return response()->json(['message' => 'User ' . $user->first_name . ' updated successfully!', 'status' => 'success', 'title' => 'Updated!', 'users' => $users], 201);
            }
            return response()->json(['message' => 'No changes found! same as previous data', 'status' => 'info', 'title' => 'No changes'], 200);
        }


        return response()->json(['message' => 'Failed to update User ' . $user->first_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }


    public function destroy(User $user)
    {
        if ($user->user_type == 'Admin') return response()->json(['message' => 'You cant delete admin', 'status' => 'info', 'title' => 'Cannot Delete'], 200);

        // Other posibilities
        // $message = null;
        // response()->json(['message' => $message, 'status' => 'info', 'title' => 'Deleted!'], 200);

        if ($user->delete()) {
            return response()->json(['message' => 'User ' . $user->first_name . ' deleted successfully!', 'status' => 'success', 'title' => 'Deleted!'], 200);
        }

        return response()->json(['message' => 'Failed to delete User ' . $user->first_name, 'status' => 'error', 'title' => 'Failed!'], 200);
    }
}
