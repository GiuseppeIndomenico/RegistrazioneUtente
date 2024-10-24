<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container">

        <a class="my-3 btn btn-primary" href="{{ route('posts.create') }}">Crea un Nuovo Post</a>

        <div class="row g-2">
            @foreach (Auth::user()->posts as $post)
                <div class=" col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow p-0 mb-3">
                        <div class="card-header text-center fs-3 text-capitalize fw-bold">
                            <h2 class="text-danger">{{ $post->title }}</h2>
                        </div>
                        <div class="card-body">
                            <p>{{ $post->content }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>

</x-app-layout>
