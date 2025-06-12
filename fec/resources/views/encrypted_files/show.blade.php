<x-layout>
    <x-slot name="title">
        {{ $file->title }}
    </x-slot>

    <h1>{{ $file->title }}</h1>
    <p><strong>filename:</strong> {{ $file->filename }}</p>
    <p><strong>Description:</strong> {{ $file->description }}</p>
    <p><strong>owner_id:</strong> {{ $file->owner_id }}</p>

    <a href="{{ route('files.index') }}" class="btn btn-secondary">Back to files</a>

    <hr>


</x-layout>