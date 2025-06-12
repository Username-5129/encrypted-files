<div class="bg-white shadow-md rounded-lg p-6 mb-4">
    <h5 class="text-xl font-semibold text-gray-900 mb-1">{{ $file->filename }}</h5>
    <h6 class="text-sm text-gray-500 mb-3">{{ $file->owner_id }}</h6>
    <p class="text-gray-700 mb-4">{{ $file->description }}</p>

    <ul class="mb-4 space-y-1 text-sm text-gray-600">
        <li><span class="font-semibold">Date:</span> {{ $file->created_at?->format('Y-m-d') }}</li>
    </ul>

    <a href="{{ route('file.show', ['file' => $file->id]) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded">
        View Details
    </a>
</div>
