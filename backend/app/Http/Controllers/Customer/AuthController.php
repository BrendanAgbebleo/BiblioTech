<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate and create a new customer
    }

    public function login(Request $request)
    {
        // Authenticate customer and return token
    }

    public function user(Request $request)
    {
        // Return authenticated customer data
        return $request->user();
    }

    public function logout(Request $request)
    {
        // Revoke token
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}

