<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\newUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return response()->json(
            [
                'message' => 'admin Panel',
            ]
        );

    }

    public function register(NewUserRequest $request)
    {
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );

        $user->assignRole($request->role);

        return response()->json(
            [
                'message' => 'User is registerd successfully.',
                'user' => $user->load('roles'),
            ], 200
        );

    }

    public function users()
    {
        $users = User::with('roles')->get();

        return response()->json(
            [
                'message' => 'user list',
                'users' => $users,
            ]
        );
    }

    public function show(User $user)
    {
        return response()->json(
            [
                'message' => 'user information:',
                'user' => $user->load('roles')
            ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email']));

        if ($request->has('role')) {
            $user->syncRoles([$request->role]);
        }

        return response()->json(
            [
                'message' => 'User updated successfully.',
                'user' => $user->load('roles')
            ]
        );
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return response()->json(
                [
                    'message' => 'Cannot delete admin user.'
                ], 403
            );
        }

        $user->syncRoles([]); // حذف نقش‌ها

        $user->delete();

        return response()->json(
            [
                'message' => 'User deleted successfully.'
            ]
        );
    }
}
