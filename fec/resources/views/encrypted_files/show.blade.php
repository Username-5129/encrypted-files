<x-layout>
    <x-slot name="title">
        {{ $file->title }}
    </x-slot>

    <h1>{{ $file->title }}</h1>
    <p><strong>Filename:</strong> {{ $file->filename }}</p>
    <p><strong>Description:</strong> {{ $file->description }}</p>
    <p><strong>Owner:</strong> {{ $file->user->name }}</p>
    <p><strong>Created at:</strong> {{ $file->created_at }}</p>
    <p><strong>Updated at:</strong> {{ $file->updated_at }}</p>
    <p><strong>Is Public:</strong> {{ $file->is_public ? 'Yes' : 'No' }}</p>

    <a href="{{ route('file.index') }}" class="btn btn-secondary">Back to files</a>

    <hr>

    <a href="{{ route('files.manageAccess', $file->id) }}" class="btn btn-secondary">Manage Access</a>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('files.checkPassword', $file) }}" method="POST">
        @csrf
        <label for="password">Enter Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit" class="btn btn-primary">Download</button>
    </form>

    @can('update', $file)
    <hr>
    <a href="{{ route('file.edit', $file->id) }}" class="btn btn-primary">Edit file</a>
    <br>
    @endcan

    @can('delete', $file)
    <hr>
    <form action="{{ route('file.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    @endcan
    <hr>

    <h2>Comments:</h2>

    <form action="{{ route('comments.store', $file->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Add a Comment:</label>
            <textarea name="content" id="content" rows="3" required class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Comment</button>
    </form>

    @foreach ($file->comments as $comment)
        <div class="comment border p-4 rounded mb-3 flex justify-between items-start gap-4">
            <div>
                <p><strong>{{ $comment->users->name }}:</strong></p>
                <p>{{ $comment->content }}</p>
            </div>
            @can('update', $comment)
            <div class="flex gap-2">
                <form action="{{ route('comments.edit', $comment->id) }}" method="GET">
                    <button type="submit" class="btn btn-warning px-3 py-1 text-sm rounded">Edit</button>
                </form>
                @can('delete', $comment)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-3 py-1 text-sm rounded">Delete file</button>
                </form>
                @endcan
            </div>
            @endcan
        </div>
    @endforeach
</x-layout>