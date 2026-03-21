<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users in a DataTable.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    /**
     * Display the specified user with related orders and items.
     */
    public function show(User $user)
    {
        // Eager load nested relationships for detailed view
        $user->load(['orders.items.product']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // This looks for resources/views/admin/users/edit.blade.php
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role'      => 'required|in:admin,customer',
            'is_active' => 'required|boolean',
        ]);

        // Safety check: Prevent admin from locking themselves out
        if (Auth::id() === $user->id && $request->is_active == 0) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update([
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('users.index')->with('success', 'User permissions updated.');
    }
}