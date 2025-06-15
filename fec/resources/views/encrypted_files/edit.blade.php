<x-layout>
    <x-slot name="title">
        Update file
    </x-slot>

    <h1 class="mb-4 text-2xl font-bold">Update file</h1>
    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('file.update', $file) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Filename</label>
            <input type="text" placeholder="Leave this empty to save the original filename" name="filename" value="{{ old('filename', $file->filename) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" rows="5">{{ old('description', $file->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Is Public</label>
            <select name="is_public" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                <option value="0" {{ old('is_public', $file->is_public) == '0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('is_public', $file->is_public) == '1' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">password_hash</label>
            <input type="text" name="password_hash" value="{{ old('password_hash', $file->password_hash) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" required>
        </div>

        <div class="mb-4">
            <label class="" for="stored_path">Upload file</label>
            <input class="" id="stored_path" name="stored_path" type="file">
        </div>

        <button type="submit" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Update file</button>
    </form>
</x-layout>