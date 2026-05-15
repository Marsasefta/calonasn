<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function userType()
    {
        $users = User::all();
        return view('admin.user_type', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return response()->json(['message' => 'Role updated successfully', 'success' => true]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        // Assuming there's an is_active field, if not we can skip this
        if ($user->fillable && in_array('is_active', $user->getFillable())) {
            $user->update(['is_active' => $request->is_active]);
        }

        return response()->json(['message' => 'Status updated successfully', 'success' => true]);
    }
}