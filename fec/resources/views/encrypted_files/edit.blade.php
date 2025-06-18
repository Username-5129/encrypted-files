<x-layout>
    <x-slot name="title">
        Edit file
    </x-slot>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4">
        <div class="max-w-2xl w-full bg-[#1e3a5c]/90 p-8 rounded-2xl shadow-2xl border border-[#5B88B2]">
            <x-slot name="header">
                <h1 class="text-2xl font-bold text-[#FBF9E4]">Edit file</h1>
            </x-slot>

            <h1 class="mb-4 text-2xl font-bold text-[#FBF9E4] text-center">Edit file</h1>
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
                    <label class="block text-sm font-medium text-[#FBF9E4]">Filename</label>
                    <input type="text" placeholder="Leave this empty to save the original filename" name="filename" value="{{ old('filename', $file->filename) }}" class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#FBF9E4]">Description</label>
                    <textarea name="description" class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60" rows="5">{{ old('description', $file->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#FBF9E4]">Is Public</label>
                    <select name="is_public" class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4]">
                        <option value="0" {{ old('is_public', $file->is_public) == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('is_public', $file->is_public) == '1' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#FBF9E4]">Old Password</label>
                    <input type="password" name="old_password_hash" value="{{ old('old_password_hash') }}" class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#FBF9E4]">Password</label>
                    <input type="password" name="password_hash" value="{{ old('password_hash') }}" class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#FBF9E4]">Confirm password</label>
                    <input type="password" name="confirm_password_hash" value="{{ old('confirm_password_hash') }}" class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#FBF9E4]" for="stored_path">Upload file</label>
                    <input class="block w-full text-sm text-[#FBF9E4] border-[#5B88B2] rounded-lg bg-[#122C4F] focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 file:bg-[#5B88B2] file:text-[#FBF9E4] file:rounded file:border-0" id="stored_path" name="stored_path" type="file">
                </div>

                <button type="submit" class="mt-4 w-full bg-[#5B88B2] text-[#FBF9E4] font-bold py-2 px-4 rounded-lg hover:bg-[#49709a] transition">Update file</button>
            </form>
        </div>
    </div>
</x-layout>