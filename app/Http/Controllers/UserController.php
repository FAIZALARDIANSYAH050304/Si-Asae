<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');
        
        $users = User::with(['roles', 'permissions'])
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            })
            ->when($role, function($query) use ($role) {
                $query->role($role);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.index', [
            'users' => $users,
            'filters' => ['search' => $search, 'role' => $role]
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        
        return view('users.create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('users/foto', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nip' => $validated['nip'],
            'jabatan' => $validated['jabatan'],
            'foto' => $fotoPath,
        ]);

        $user->syncRoles($validated['roles']);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        $user->load(['roles', 'permissions']);
        
        return view('users.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id . '|max:255',
            'password' => 'nullable|string|min:8|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('users/foto', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        $user->syncRoles($validated['roles']);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }
        
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function roles()
    {
        $roles = Role::with('permissions')->get();
        
        return view('users.roles', [
            'roles' => $roles
        ]);
    }

    public function createRole()
    {
        $permissions = Permission::all();
        
        return view('users.create-role', [
            'permissions' => $permissions
        ]);
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        
        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('users.roles')
            ->with('success', 'Role berhasil ditambahkan');
    }

    public function editRole(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('users.edit-role', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function updateRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id . '|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('users.roles')
            ->with('success', 'Role berhasil diperbarui');
    }

    public function destroyRole(Role $role)
    {
        $role->delete();

        return redirect()->route('users.roles')
            ->with('success', 'Role berhasil dihapus');
    }

    public function permissions()
    {
        $permissions = Permission::all()->groupBy('group');
        
        return view('users.permissions', [
            'permissions' => $permissions
        ]);
    }

    public function createPermission()
    {
        return view('users.create-permission');
    }

    public function storePermission(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
            'group' => 'required|string|max:255',
        ]);

        Permission::create($validated);

        return redirect()->route('users.permissions')
            ->with('success', 'Permission berhasil ditambahkan');
    }

    public function destroyPermission(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('users.permissions')
            ->with('success', 'Permission berhasil dihapus');
    }
}
