<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaffLog;
use Illuminate\Support\Facades\Auth;

class StaffLogController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff || $staff->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $logs = StaffLog::with('staffUser:id,uid,name')
            ->latest()
            ->paginate(25);

        return response()->json($logs);
    }
}
