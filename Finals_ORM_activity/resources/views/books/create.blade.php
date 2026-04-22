<h1>Add New Book</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{ route('books.store') }}" method="POST">
    @csrf

    <label for="title">Title:</label>
    <input type="text" id="title" name="title">
    <br>

    <label for="author">Author:</label>
    <input type="text" id="author" name="author">
    <br>

    <label for="published_date">Published Date:</label>
    <input type="date" id="published_date" name="published_date">
    <br>

    <button type="submit">Save</button>
</form>