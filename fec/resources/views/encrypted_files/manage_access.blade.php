<x-layout>
    <x-slot name="title">
        Manage Access for {{ $file->filename }}
    </x-slot>

    <h1>Manage Access for {{ $file->filename }}</h1>

    <h2>Users with Access:</h2>
    <ul>
        @foreach ($usersWithAccess as $access)
            <li>
                {{ $access->users->name }} ({{ $access->users->email }})
                <form action="{{ route('files.toggleEdit', [$file->id, $access->users->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        {{ $access->can_edit ? 'Disable Editing' : 'Enable Editing' }}
                    </button>
                </form>
                <form action="{{ route('files.removeAccess', [$file->id, $access->users->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>
            </li>
        @endforeach
    </ul>

    <h2>Friends without Access:</h2>
    <ul>
        @foreach ($friendsWithoutAccess as $friend)
            <li>
                {{ $friend->name }} ({{ $friend->email }})
                <form action="{{ route('files.addAccess', [$file->id, $friend->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Grant Access</button>
                </form>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('files.show', $file->id) }}" class="btn btn-secondary">Back to File</a>
</x-layout>