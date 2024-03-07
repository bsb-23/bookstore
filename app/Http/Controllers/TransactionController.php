<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Sale;
use App\Models\Purchase;

class TransactionController extends Controller
{
    public function showSellForm()
    {
        $books = Book::all(); 

        return view('books.sell', compact('books'));
    }
    
    public function createSale(Request $request)
    {
        $request->validate([
            'books' => 'required|array',
            'quantity' => 'required|integer|min:1',
        ]);
    
        foreach ($request->books as $bookId) {
            $book = Book::findOrFail($bookId);
    
            if ($book->quantity < $request->input('quantity')) {
                return redirect()->back()->withErrors(['books' => 'Insufficient quantity for book: ' . $book->title]);
            }
    
            $transaction = Transaction::create([
                'book_id' => $bookId,
                'transaction_type' => 0, 
                'quantity' => $request->input('quantity'),
            ]);
    
            $book->quantity -= $request->input('quantity');
            $book->save();
    
            Sale::create([
                'transaction_id' => $transaction->id,
            ]);
        }
    
        return redirect()->route('books.index')->with('success', 'Books sold successfully.');
    }

    public function showPurchaseForm()
    {
        $books = Book::all(); 

        return view('books.purchase', compact('books'));
    }

    public function createPurchase(Request $request)
    {
        $request->validate([
            'books' => 'required|array',
            'quantity' => 'required|integer|min:1',
        ]);
    
        foreach ($request->books as $bookId) {
            $book = Book::findOrFail($bookId);
    
            $transaction = Transaction::create([
                'book_id' => $bookId,
                'transaction_type' => 1,
                'quantity' => $request->input('quantity'),
            ]);
    
            $book->quantity -= $request->input('quantity');
            $book->save();
    
            Purchase::create([
                'transaction_id' => $transaction->id,
            ]);
        }
    
        return redirect()->route('books.index')->with('success', 'Books purchased successfully.');
    }
}

