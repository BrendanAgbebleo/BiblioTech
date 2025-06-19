<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StaffUser;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Authenticate staff and return token
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
