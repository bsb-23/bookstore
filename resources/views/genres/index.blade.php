@extends('layouts.default')

@section('content')
<section class="flex justify-center items-center text-center min-h-1/2 min-w-1/2 shadow-lg p-4 h-auto w-auto">
    <div>
        <h1 class="text-blue-700 text-3xl">Here are the list of Genres : </h1>
        <div class="flex flex-col justify-evenly items-center space-y-2 mt-8">
            <h1 class="text-2xl text-blue-700">All Genres</h1>
            <a href="{{ route('genres.create') }}" class="rounded-full bg-blue-700 text-white font-semibold p-4">Add New Genre</a>
            <table class="table">
                <thead>
                    <tr class="p-4">
                        <th class="p-2">Name</th>
                        <th class="p-2">Books</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="tbody-index">
                    @foreach ($genres as $genre)
                        <tr>
                            <td>{{ $genre->name }}</td>
                            <td>
                                @foreach ($genre->books as $book)
                                {{ $book->title }}@if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 p-4 rounded-lg text-white" onclick="return confirm('Are you sure you want to delete this genre?')">Delete</button>
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