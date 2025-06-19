<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // GET /customer/books or /staff/books
    public function index(Request $request)
    {
        $books = Book::with('categories')->get();

        // Optional: Return different formats or filtered data
        if ($request->user('staff')) {
            // Staff: full data
            return response()->json([
                'view' => 'staff.books.index',
                'books' => $books
            ]);
        }

        if ($request->user('customer')) {
            // Customers: maybe less details
            $customerViewData = $books->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'categories' => $book->categories->pluck('name'),
                    'price' => $book->price,
                    'description' => $book->description,
                ];
            });

            return response()->json([
                'view' => 'customer.books.index',
                'books' => $customerViewData
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // GET /customer/books/{id} or /staff/books/{id}
    public function show($id)
    {
        $book = Book::with('categories')->findOrFail($id);
        return response()->json($book);
    }

    // POST /staff/books
    public function store(Request $request)
    {
        $this->authorizeStaff();

        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $book = Book::create($validated);

        return response()->json(['message' => 'Book created', 'book' => $book], 201);
    }

    // PUT /staff/books/{id}
    public function update(Request $request, $id)
    {
        $this->authorizeStaff();

        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'author' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'description' => 'nullable|string',
        ]);

        $book->update($validated);

        return response()->json(['message' => 'Book updated', 'book' => $book]);
    }

    // DELETE /staff/books/{id}
    public function destroy($id)
    {
        $this->authorizeStaff();

        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted']);
    }

    // Helper: only staff should access certain actions
    protected function authorizeStaff()
    {
        if (!Auth::guard('staff')->check()) {
            abort(403, 'Only staff can perform this action');
        }
    }
}
