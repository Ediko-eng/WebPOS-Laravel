<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('userid')->get();

        return view('user.data', compact('users'));
    }

    public function create()
    {
        return view('user.form');
    }

    public function edit(Request $request)
    {
        $user = User::findOrFail($request->query('id'));

        return view('user.form', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:30|unique:tbl_user,username',
            'fullname' => 'required|string|max:100',
            'password' => 'required|string|min:4',
            'password2' => 'required|string|same:password',
            'level' => 'required|integer|in:1,2,3',
            'address' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3072',
        ], [
            'password2.same' => 'Konfirmasi password tidak sesuai, user baru gagal diregistrasi !',
            'username.unique' => 'Username sudah terpakai, user baru gagal diregistrasi !',
        ]);

        $foto = 'default.png';
        if ($request->hasFile('image')) {
            $ext = strtolower($request->file('image')->getClientOriginalExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                return back()->withErrors(['image' => 'File neebe mak ita upload laos gambar.'])->withInput();
            }
            $foto = rand(10, 1000) . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('asset/image'), $foto);
        }

        User::create([
            'username' => strtolower($validated['username']),
            'fullname' => $validated['fullname'],
            'password' => Hash::make($validated['password']),
            'address' => $validated['address'] ?? '',
            'level' => $validated['level'],
            'foto' => $foto,
        ]);

        return redirect()->route('user.index')->with('success', 'Utilizador foun registu ho susesu..');
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->input('id'));

        $validated = $request->validate([
            'username' => 'required|string|max:30',
            'fullname' => 'required|string|max:100',
            'level' => 'required|integer|in:1,2,3',
            'address' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3072',
        ]);

        $cekUsername = User::where('username', strtolower($validated['username']))
            ->where('userid', '!=', $user->userid);
        if ($cekUsername->exists()) {
            return back()->withErrors(['username' => 'Username nee uza tiha ona.'])->withInput();
        }

        $foto = $user->foto;
        if ($request->hasFile('image')) {
            $ext = strtolower($request->file('image')->getClientOriginalExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                return back()->withErrors(['image' => 'File neebe mak ita upload laos gambar.'])->withInput();
            }
            $newFoto = rand(10, 1000) . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('asset/image'), $newFoto);
            if ($foto && $foto !== 'default.png') {
                @unlink(public_path('asset/image/' . $foto));
            }
            $foto = $newFoto;
        }

        $user->update([
            'username' => strtolower($validated['username']),
            'fullname' => $validated['fullname'],
            'address' => $validated['address'] ?? '',
            'level' => $validated['level'],
            'foto' => $foto,
        ]);

        return redirect()->route('user.index')->with('success', 'Dadus utilizador hadia ho susesu');
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->query('id'));

        if ($user->foto && $user->foto !== 'default.png') {
            @unlink(public_path('asset/image/' . $user->foto));
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'Utilizador hamoos ho susesu');
    }
}
