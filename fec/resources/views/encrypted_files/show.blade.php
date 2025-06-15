<x-layout>
    <x-slot name="title">
        {{ $file->title }}
    </x-slot>

    <h1>{{ $file->title }}</h1>
    <p><strong>filename:</strong> {{ $file->filename }}</p>
    <p><strong>Description:</strong> {{ $file->description }}</p>
    <p><strong>owner_id:</strong> {{ $file->owner_id }}</p>

    <a href="{{ route('file.index') }}" class="btn btn-secondary">Back to files</a>

    <hr>

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
</x-layout>