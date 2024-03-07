@extends('layouts.default')

@section('content')
<section class="flex justify-center items-center text-center min-h-1/2 min-w-1/2 shadow-lg p-4 h-auto w-auto">
    <div>
        <h1 class="text-blue-700 text-3xl">Here are the list of Books : </h1>
        <div class="flex flex-col justify-evenly items-center space-y-2 mt-8">
            <h1 class="text-2xl text-blue-700">All Books</h1>
            <a href="{{ route('books.create') }}" class="rounded-full bg-blue-700 text-white font-semibold p-4">Add New Book</a>
            <a href="{{ route('books.sell') }}" class="rounded-full bg-blue-700 text-white font-semibold p-4">Sell Books</a>
            <a href="{{ route('books.purchase') }}" class="rounded-full bg-blue-700 text-white font-semibold p-4">Purchase Books</a>
            <table class="table">
                <thead>
                    <tr class="p-4">
                        <th class="p-2">ISBN</th>
                        <th class="p-2">Title</th>
                        <th class="p-2">Author</th>
                        <th class="p-2">Genre</th>
                        <th class="p-2">Publisher</th>
                        <th class="p-2">Published Date</th>
                        <th class="p-2">Price</th>
                        <th class="p-2">Quantity</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="tbody-index">
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->title }}</td>
                            <td>
                                @foreach ($book->authors as $author)
                                {{ $author->name }}@if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td>@foreach ($book->genres as $genre)
                                {{ $genre->name }}@if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td>{{ $book->publisher->name }}</td>
                            <td>{{ $book->published_date }}</td>
                            <td>{{ $book->price }}</td>
                            <td>{{ $book->quantity }}</td>
                            <td>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 p-4 rounded-lg text-white" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection