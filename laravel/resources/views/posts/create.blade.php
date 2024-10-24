<h1>Crea un Nuovo Post</h1>

<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <div>
        <label for="title">Titolo:</label>
        <input type="text" id="title" name="title" required>
    </div>

    <div>
        <label for="content">Contenuto:</label>
        <textarea id="content" name="content" required></textarea>
    </div>

    <button type="submit">Crea Post</button>
</form>
