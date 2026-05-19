<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
use Illuminate\Http\Request;

class CreateTryoutController extends Controller
{
    public function createTryout()
    {
        $tryouts = Tryout::latest()->get();

        return view('admin.create_tryout', compact('tryouts'));
    }

    public function storeTryout(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule_at' => 'nullable|date',
            'duration_minutes' => 'nullable|integer|min:1',
            'price' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'status' => 'required|in:draft,active,archived',
        ]);

        Tryout::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'schedule_at' => $validated['schedule_at'] ?? null,
            'duration_minutes' => $validated['duration_minutes'] ?? null,
            'price' => $validated['price'] ?? 0,
            'is_active' => $validated['is_active'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.create-tryout')->with('success', 'Sesi tryout berhasil dibuat.');
    }
}