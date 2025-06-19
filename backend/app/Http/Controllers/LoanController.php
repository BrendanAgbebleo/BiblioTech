<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\BookCopy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LoanController extends Controller
{
    // GET /staff/loans
    public function index()
    {
        $this->authorizeStaff();

        $loans = Loan::with(['customer', 'bookCopy.book'])->whereNull('returned_at')->get();

        return response()->json($loans);
    }

    // POST /staff/loans
    public function store(Request $request)
    {
        $this->authorizeStaff();

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'book_copy_id' => 'required|exists:book_copies,id',
            'due_at' => 'required|date|after:today',
        ]);

        // Ensure book copy is available
        $bookCopy = BookCopy::findOrFail($validated['book_copy_id']);
        if (!$bookCopy->available) {
            return response()->json(['message' => 'Book copy not available'], 409);
        }

        $loan = Loan::create([
            'customer_id' => $validated['customer_id'],
            'book_copy_id' => $validated['book_copy_id'],
            'borrowed_at' => now(),
            'due_at' => Carbon::parse($validated['due_at']),
        ]);

        // Mark book copy as unavailable
        $bookCopy->update(['available' => false]);

        return response()->json(['message' => 'Loan created', 'loan' => $loan], 201);
    }

    // GET /staff/loans/{id}
    public function show($id)
    {
        $this->authorizeStaff();

        $loan = Loan::with(['customer', 'bookCopy.book'])->findOrFail($id);

        return response()->json($loan);
    }

    // PUT /staff/loans/{id}
    public function update(Request $request, $id)
    {
        $this->authorizeStaff();

        $loan = Loan::findOrFail($id);

        $validated = $request->validate([
            'returned_at' => 'nullable|date|before_or_equal:today',
        ]);

        $loan->returned_at = $validated['returned_at'] ?? now();
        $loan->is_overdue = $loan->returned_at > $loan->due_at;
        $loan->save();


        // Mark book copy as available again
        $loan->bookCopy->update(['available' => true]);

        return response()->json(['message' => 'Loan marked as returned', 'loan' => $loan]);
    }

    // DELETE /staff/loans/{id}
    public function destroy($id)
    {
        $this->authorizeStaff();

        $loan = Loan::findOrFail($id);

        // Optional: check if returned
        if (!$loan->returned_at) {
            return response()->json(['message' => 'Cannot delete an active loan'], 403);
        }

        $loan->delete();

        return response()->json(['message' => 'Loan record deleted']);
    }

    // GET /customer/loan-history
    public function customerHistory(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $loans = Loan::with('bookCopy.book')
            ->where('customer_id', $customer->id)
            ->orderByDesc('loaned_at')
            ->get();

        return response()->json($loans);
    }

    // GET /staff/overdue-alerts
    public function overdueAlerts()
    {
        $this->authorizeStaff();

        $overdueLoans = Loan::with(['customer', 'bookCopy.book'])
            ->whereNull('returned_at')
            ->where('due_at', '<', now())
            ->get();

        return response()->json($overdueLoans);
    }

    protected function authorizeStaff()
    {
        if (!Auth::guard('staff')->check()) {
            abort(403, 'Only staff can perform this action');
        }
    }
}
