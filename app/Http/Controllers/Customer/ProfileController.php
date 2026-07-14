<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('customer.profile.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'phone' => 'nullable|string|max:20',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        return redirect()
            ->route('customer.profile.index')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'required',

            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors([
                    'current_password' => 'Current password is incorrect.',
                ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('customer.profile.index')
            ->with('success', 'Password updated successfully.');
    }
}