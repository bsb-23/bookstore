@extends('layouts.default')

@section('content')
<section class="flex justify-center items-center text-center min-h-1/2 min-w-1/2 shadow-lg p-4 h-full w-full">
    <div class="my-auto">
        <div>
            <h1 class="text-blue-700 text-3xl">Add a Genre : </h1>
            <div class="flex flex-col justify-evenly items-center space-y-2 mt-8">
                <form action="{{ route('genres.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-col justify-evenly items-start text-center space-y-4">
                        <div><label for="name">Name : </label><input type="text" id="name" name="name" placeholder="Name" class="rounded-full py-2 px-4 outline-none ml-2 bg-gray-100"></div>
                        <div class="text-center"><button type="submit" class="py-2 px-4 outline-none ml-2 rounded-full bg-blue-600 text-white">Submit</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
