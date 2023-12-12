<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Inertia\Inertia;

class BookController extends Controller
{
    //
    public function index() {
        $books = Book::all();
        return Inertia::render('Book/Index', compact('books'));
    }
    public function create()
    {
        return Inertia::render('Book/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'isbn' => 'required',
            'description' => 'required',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book created successfully');
    }

    public function edit(Book $book)
    {
        return Inertia::render('Book/Edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'isbn' => 'required',
            'description' => 'required',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }
}