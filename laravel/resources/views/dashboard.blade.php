<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <button class="my-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPostModal">Crea un Nuovo
            Post</button>

        <!-- Modale per la creazione del post -->
        <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPostModalLabel">Crea un Nuovo Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createPostForm" method="POST" action="{{ route('posts.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="post_title" class="form-label">Titolo</label>
                                <input type="text" class="form-control" id="post_title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="post_content" class="form-label">Contenuto</label>
                                <textarea class="form-control" id="post_content" name="content" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    onclick="resetForm()">Annulla</button>
                                <button type="submit" class="btn btn-primary">Crea</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row g-2">
            @foreach (Auth::user()->posts as $post)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
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

<script>
    function resetForm() {
        document.getElementById('createPostForm').reset(); // Resetta il modulo
    }
</script>
