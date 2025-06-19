<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{
    public function index()
    {
        // List all active loans (staff)
    }

    public function store(Request $request)
    {
        // Create a new loan (staff)
    }

    public function show($id)
    {
        // Show details of a specific loan
    }

    public function update(Request $request, $id)
    {
        // Mark loan as returned or update status
    }

    public function destroy($id)
    {
        // Optionally delete loan record (if allowed)
    }

    public function customerHistory(Request $request)
    {
        // Show loans for authenticated customer
    }

    public function overdueAlerts()
    {
        // Return list of overdue loans (staff)
    }
}
