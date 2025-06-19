<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    // 1. Create a new staff user
    public function createStaff(Request $request)
    {
        $request->validate([
            'uid' => 'required|string|unique:staff_users,uid',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:staff_users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $staff = StaffUser::create([
            'uid' => $request->uid,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'staff', // Default role
        ]);

        return response()->json(['staff' => $staff], 201);
    }

    // 2. List all staff users
    public function listStaff()
    {
        return StaffUser::all();
    }

    // 3. Promote a staff user to admin (max: 1)
    public function assignAdmin(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff_users,id',
        ]);

        $maxAdmins = 3;
        $adminCount = StaffUser::where('role', 'admin')->count();

        if ($adminCount >= $maxAdmins) {
            return response()->json(['message' => 'Max number of admins reached'], 403);
        }

        $staff = StaffUser::find($request->staff_id);
        $staff->role = 'admin';
        $staff->save();

        return response()->json(['message' => 'Staff promoted to admin']);
    }

    // 4. Transfer admin authority to another staff
    public function transferAdminAuthority(Request $request)
    {
        $request->validate([
            'to_staff_id' => 'required|exists:staff_users,id',
        ]);

        $admin = $request->user();

        if ($admin->role !== 'admin') {
            return response()->json(['message' => 'Only admins can transfer authority'], 403);
        }

        $toStaff = StaffUser::find($request->to_staff_id);

        $toStaff->role = 'admin';
        $toStaff->save();

        $admin->role = 'staff';
        $admin->save();

        return response()->json(['message' => 'Admin rights transferred']);
    }

    // 5. Relinquish admin authority
    public function relinquishAdmin(Request $request)
    {
        $admin = $request->user();

        if ($admin->role !== 'admin') {
            return response()->json(['message' => 'Only admins can relinquish authority'], 403);
        }

        $remainingAdmins = StaffUser::where('role', 'admin')->where('id', '!=', $admin->id)->count();

        if ($remainingAdmins < 1) {
            return response()->json(['message' => 'At least one admin is required'], 403);
        }

        $admin->role = 'staff';
        $admin->save();

        return response()->json(['message' => 'Admin privileges removed']);
    }
}

