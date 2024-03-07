@extends('layouts.default')

@section('content')
<section class="flex justify-center items-center text-center min-h-1/2 min-w-1/2 shadow-lg p-4 h-auto w-auto">
    <div>
        <h1 class="text-blue-700 text-3xl">Edit Author</h1>
        <div class="mt-8">
            <form action="{{ route('authors.update', $author->id) }}" method="POST" class="max-w-md mx-auto">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-blue-700 font-bold mb-2">Author Name</label>
                    <input type="text" name="name" id="name" class="border-2 border-blue-700 rounded-md p-2 w-full" value="{{ $author->name }}" required>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">Update Author</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
