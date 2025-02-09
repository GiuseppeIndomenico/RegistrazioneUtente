<x-app-layout>
    <x-slot name="header">
        <h1 class="font-bold fs-1 text-xl text-dark leading-tight">
            {{ Auth::user()->name . __('\'s thoughts') }}
        </h1>
        @if (session('success'))
            <div
                class="alert bg-dark txt-pr glow-pr border-0 position-fixed top-0 start-50 translate-middle-x w-25  text-center mt-5 sticky">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>


    <div class="container background-pat">

        <button class="my-3 btn btn-dark glow-pr border-0" data-bs-toggle="modal" data-bs-target="#createPostModal">Create
            a new
            post
            Post</button>

        <!-- Modale per la creazione del post -->
        <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-pr txt-dark border-dark">
                        <h5 class="modal-title" id="createPostModalLabel">Crete a new Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body txt-pr bg-dark">
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
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                                    onclick="resetForm()">Annulla</button>
                                <button type="submit" class="btn btn-dark">Crea</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row g-4 bg-pr-light container-post glow-pr">
            @foreach (Auth::user()->posts as $post)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 position-relative">
                    <div class="card border-dark shadow p-0 mb-3">
                        <div class="card-header bg-dark text-center fs-3 text-capitalize fw-bold">
                            <h2 class="txt-pr">{{ $post->title }}</h2>
                            <!-- X per cancellare -->
                            <button class="btn btn-dark position-absolute del-btn"
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
            <div class="modal-header border-dark bg-pr text-dark">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Conferma Cancellazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark txt-pr">
                Sei sicuro di voler cancellare questo post?
            </div>
            <div class="modal-footer bg-dark ">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-dark" id="deletePostButton">Cancella</button>
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
