<x-layout>
    <x-slot name="title">
        Update file
    </x-slot>

    <h1 class="">Update file</h1>
        @if ($errors->any())
        <div class="">
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
                <input type="text" placeholder="Leave this empty to save the original filename" name="filename" value="{{ old('filename', $file->filename) }}" class="">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" class="" rows="5">{{ old('description', $file->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Is Public</label>
                <select name="is_public" class="">
                    <option value="0" {{ old('is_public', $file->is_public) == '0' ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('is_public', $file->is_public) == '1' ? 'selected' : '' }}>Yes</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Old password</label>
                <input type="text" name="old_password_hash" value="{{ old('old_password_hash') }}" class="">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">New password</label>
                <input type="text" name="password_hash" value="{{ old('password_hash') }}" class="">
            </div>

            <div class="mb-4">
                <label class="" for="stored_path">Upload file</label>
                <input class="" id="stored_path" name="stored_path" type="file">
            </div>

            <button type="submit" class="">Update file</button>
        </form>
    </div>
</x-layout>