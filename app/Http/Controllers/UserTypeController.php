<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTypeController extends Controller
{
    public function userType()
    {
        $users = User::with(['transactions' => function ($q) {
            $q->whereRaw('LOWER(status) = ?', ['success']);
        }])->orderBy('created_at', 'desc')->get();

        foreach ($users as $user) {
            $successTryoutIds = $user->transactions->pluck('tryout_id')->toArray();
            $hasPaket1 = in_array(1, $successTryoutIds);
            $hasPaket2 = in_array(2, $successTryoutIds);
            $hasPaket3 = in_array(3, $successTryoutIds);

            if ($hasPaket2 || ($hasPaket1 && $hasPaket3)) {
                $user->package_status = 'lengkap';
                $user->package_label = 'Paket Lengkap';
                $user->package_sublabel = 'Tryout + Materi';
            } elseif ($hasPaket1) {
                $user->package_status = 'tryout';
                $user->package_label = 'Tryout Saja';
                $user->package_sublabel = 'Belum Materi';
            } elseif ($user->is_premium) {
                $user->package_status = 'manual';
                $user->package_label = 'PRO Khusus';
                $user->package_sublabel = 'Akses Manual';
            } else {
                $user->package_status = 'free';
                $user->package_label = 'Free User';
                $user->package_sublabel = 'Belum Beli';
            }
        }

        return view('admin.user_type', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:25',
            'role' => 'required|in:user,admin',
            'is_premium' => 'nullable|boolean',
        ]);

        $password = Str::random(8);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'is_premium' => $request->boolean('is_premium', false),
            'password' => Hash::make($password),
        ]);

        return back()->with('success', 'Peserta berhasil ditambahkan. Password awal: ' . $password);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user_profile', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user_edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:25',
            'role' => 'required|in:user,admin',
            'is_premium' => 'nullable|boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'is_premium' => $request->boolean('is_premium', false),
        ]);

        return redirect()
            ->route('admin.users.show', $user->id)
            ->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Peserta berhasil dihapus.');
    }

    public function togglePremium(Request $request, $id)
    {
        $request->validate([
            'is_premium' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->update(['is_premium' => $request->is_premium]);

        return response()->json(['message' => 'Status Premium berhasil diperbarui.', 'success' => true]);
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $defaultPassword = 'Pass1234!';
        $user->update(['password' => Hash::make($defaultPassword)]);

        return back()->with('success', 'Password peserta berhasil direset menjadi: ' . $defaultPassword);
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
        if ($user->fillable && in_array('is_active', $user->getFillable())) {
            $user->update(['is_active' => $request->is_active]);
        }

        return response()->json(['message' => 'Status updated successfully', 'success' => true]);
    }
}
