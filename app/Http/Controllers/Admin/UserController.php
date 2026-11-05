<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private const ROLE = ['admin', 'petugas', 'siswa'];

    public function index()
    {
        return view('admin.users.index', [
            'users' => User::with('roles')->orderBy('name')->get(),
            'roles' => Role::whereIn('name', self::ROLE)->orderBy('name')->pluck('name'),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->can('kelola role pengguna'), 403);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'ends_with:@gmail.com', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', Rule::in(self::ROLE)],
        ], [
            'email.ends_with' => 'Email harus menggunakan alamat @gmail.com.',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole($data['role']);

        return back()->with('status', 'Pengguna berhasil ditambahkan.');
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(self::ROLE)],
        ]);

        if ($user->id === $request->user()->id) {
            return back()->withErrors(['role' => 'Anda tidak dapat mengubah role akun Anda sendiri.']);
        }

        $user->syncRoles([$data['role']]);

        return back()->with('status', 'Role pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->withErrors(['hapus' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user->delete();

        return back()->with('status', 'Pengguna berhasil dihapus.');
    }
}