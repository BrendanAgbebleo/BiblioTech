<?php

namespace App\Http\Controllers\Staff;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\StaffUser;

class AuthController extends Controller
{
    public function login(Request $request)
    {
         $request->validate([
            'uid' => 'required|string',
            'password' => 'required|string',
        ]);

        $staff = StaffUser::where('uid', $request->uid)->first();

        if (! $staff || ! Hash::check($request->password, $staff->password)) {
            throw ValidationException::withMessages([
                'uid' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Revoke old tokens (optional)
        $staff->tokens()->delete();

        $token = $staff->createToken('staff-token')->plainTextToken;

        return response()->json([
            'user' => $staff,
            'token' => $token,
        ]);
    }

    public function user(Request $request)
    {
        // Return authenticated staff data
        return $request->user();
    }

    public function logout(Request $request)
    {
        // Revoke token
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
