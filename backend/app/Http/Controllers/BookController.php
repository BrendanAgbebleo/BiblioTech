<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        // List all books (for customers)
    }

    public function show($id)
    {
        // Show single book details
    }

    public function store(Request $request)
    {
        // Add a new book (staff only)
    }

    public function update(Request $request, $id)
    {
        // Update book details
    }

    public function destroy($id)
    {
        // Delete a book
    }
}
