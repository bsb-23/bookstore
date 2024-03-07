<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $publishers = Publisher::all();
        $genres = Genre::all();
        $authors = Author::all();
        return view('books.create', compact('publishers', 'authors', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|unique:books',
            'title' => 'required',
            'publisher_id' => 'required',
            'publish_date' => 'required|date',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'authors' => 'required|array',
            'genres' => 'required|array',
        ]);

        $book = Book::create([
            'isbn' => $request->isbn,
            'title' => $request->title,
            'publisher_id' => $request->publisher_id,
            'published_date' => $request->publish_date,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        $book->authors()->attach($request->authors);

        $book->genres()->attach($request->genres);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $authors = Author::all();
        $genres = Genre::all();
        $publishers = Publisher::all();
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book', 'authors', 'genres', 'publishers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'isbn' => 'required|unique:books,isbn,' . $book->id,
            'title' => 'required',
            'publisher_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'authors' => 'required|array',
            'genres' => 'required|array',
        ]);

        $book->update([
            'isbn' => $request->isbn,
            'title' => $request->title,
            'publisher_id' => $request->publisher_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        $book->authors()->sync($request->authors);
        $book->genres()->sync($request->genres);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    public function sellForm()
    {
        $books = Book::select('id', 'title', 'quantity')->where('quantity', '>', 0)->get();
        return view('books.sell', compact('books'));
    }

    public function sell(Request $request)
    {
        $request->validate([
            'books' => 'required|array',
            'books.*.id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->books as $bookData) {
                $book = Book::findOrFail($bookData['id']);

                if ($book->quantity < $bookData['quantity']) {
                    throw new \Exception("Insufficient quantity for book: $book->title");
                }

                $transaction = new Transaction();
                $transaction->transaction_type = 0;
                $transaction->quantity = $bookData['quantity'];
                $transaction->save();

                $book->decrement('quantity', $bookData['quantity']);
            }

            DB::commit();

            return redirect()->route('books.index')->with('success', 'Books sold successfully.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
