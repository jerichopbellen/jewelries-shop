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

    /**
     * Update the role of a user.
     */
    public function updateRole(Request $request, User $user)
    {
        // Prevent admins from accidentally de-promoting themselves
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', "Role for {$user->name} updated to {$request->role}.");
    }
}