<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'curPass' => 'required|string',
            'newPass' => 'required|string|min:4',
            'confPass' => 'required|string|same:newPass',
        ], [
            'confPass.same' => 'Password konfirmasaun la hanesan.',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->curPass, $user->password)) {
            return back()->withErrors([
                'curPass' => 'Password tuan sala.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->newPass),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Password troka ho susesu.');
    }
}
