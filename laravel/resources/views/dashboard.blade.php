<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        @if (session('success'))
            <div
                class="alert alert-success position-fixed top-0 start-50 translate-middle-x w-25  text-center mt-5 sticky">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>


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
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 position-relative">
                    <div class="card shadow p-0 mb-3">
                        <div class="card-header text-center fs-3 text-capitalize fw-bold">
                            <h2 class="text-danger">{{ $post->title }}</h2>
                            <!-- X per cancellare -->
                            <button class="btn btn-outline-danger position-absolute top-0 end-0 m-2 del-btn"
                                onclick="confirmDelete('{{ $post->id }}')" id="delete-btn-{{ $post->id }}"><i
                                    class="fa-solid fa-trash"></i></button>
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
<!-- Modale di conferma cancellazione -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Conferma Cancellazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler cancellare questo post?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-danger" id="deletePostButton">Cancella</button>
            </div>
        </div>
    </div>
</div>

</div>


<script>
    function resetForm() {
        document.getElementById('createPostForm').reset();
    }

    function confirmDelete(postId) {
        // Mostra il modale di conferma
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();

        // Aggiungi l'ID del post al pulsante di cancellazione
        document.getElementById('deletePostButton').setAttribute('data-id', postId);
    }

    document.getElementById('deletePostButton').addEventListener('click', function() {
        const postId = this.getAttribute('data-id');

        // Quando viene confermata la cancellazione, effettua una normale richiesta di cancellazione
        window.location.href = `/posts/${postId}/delete`;
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Se l'alert di successo è presente
        const alert = document.querySelector('.alert-success');

        if (alert) {
            // Dopo 3 secondi (3000 ms), fai scomparire l'alert
            setTimeout(function() {
                alert.style.transition = "opacity 0.5s ease"; // Transizione di opacità
                alert.style.opacity = '0'; // Fai svanire l'alert

                // Dopo 500ms (tempo per la transizione), nascondi l'alert con display: none
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500); // Attendi che la transizione sia completata
            }, 13000); // L'alert resta visibile per 3 secondi
        }
    });
</script>
