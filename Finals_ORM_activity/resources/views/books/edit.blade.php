<h1>Edit Book</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{ route('books.update', $books->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="{{ $books->title }}" required>
    <br>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" value="{{ $books->author }}" required>
    <br>

    <label for="published_date">Published Date:</label>
    <input type="date" id="published_date" name="published_date" value="{{ $books->published_date }}" required>
    <br>

    <button type="submit">Save Changes</button>
</form>