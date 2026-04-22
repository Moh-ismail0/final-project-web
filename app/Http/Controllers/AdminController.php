<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $admins = Admin::orderBy('id', 'desc')->paginate(10);
    $users  = User::orderBy('id', 'desc')->paginate(10);
    return response()->view('admins.index', compact('admins', 'users'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:admins',
            'password' => 'required|min:6'
        ]);

        Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'icon'  => 'success',
            'title' => 'Admin Added!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->json([
            'icon'  => 'success',
            'title' => 'Admin Deleted!'
        ]);
    }

public function storeUser(Request $request)
{
    $request->validate([
        'name'     => 'required',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6'
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password)
    ]);

    return response()->json([
        'icon'  => 'success',
        'title' => 'User Added!'
    ]);
}

public function destroyUser(User $user)
{
    $user->delete();
    return response()->json([
        'icon'  => 'success',
        'title' => 'User Deleted!'
    ]);
}
}
