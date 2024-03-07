@extends('layouts.default')

@section('content')
<section class="flex justify-center items-center text-center min-h-1/2 min-w-1/2 shadow-lg p-4 h-full w-full">
    <div class="my-auto">
        <div>
        <h1 class="text-blue-700 text-3xl">Purchases Books</h1>
        <div class="flex flex-col justify-evenly items-center space-y-2 mt-8">

        <form method="POST" action="{{ route('purchases.create') }}">
            @csrf
            <div class="flex flex-col justify-evenly items-start text-center space-y-4">
                <div>
                    <label for="books">Select Books:</label>
                    <select name="books[]" id="books" class="border-2 border-blue-700 rounded-md px-8 py-4 w-96" multiple>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">{{ $book->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" class="rounded-full py-2 px-4 outline-none ml-2 bg-gray-100" placeholder="Quantity">
                </div>
            </div>
            
            <button type="submit" class="py-2 px-4 outline-none ml-2 rounded-full bg-blue-600 text-white">Purchases</button>
        </form>
    </div>
    </div>
    </div>
</section>
@endsection
