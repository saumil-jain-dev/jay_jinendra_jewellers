<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guarantor;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $users = User::all();  // Retrieve all users
        return view('users.index', compact('users'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('users.create');  // Return the user creation form view
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {

        // Validate user input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone'=>'required',
            'address'=>'required'
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address

        ]);

        return redirect()->route('users.index');  // Redirect to the users list
    }

    // Display the specified resource
    public function show(User $user)
    {
        return view('users.show', compact('user'));  // Show details of the specific user
    }

    // Show the form for editing the specified resource
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));  // Return the user edit form
    }

    // Update the specified resource in storage
    public function update(Request $request, User $user)
    {

        // Validate user input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Update the user information
        $user->update($request->all());

        return redirect()->route('users.index');  // Redirect to the users list
    }

    // Remove the specified resource from storage
    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        return redirect()->route('users.index');  // Redirect to the users list
    }
}
