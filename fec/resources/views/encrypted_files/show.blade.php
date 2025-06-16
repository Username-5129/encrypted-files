<x-layout>
    <x-slot name="title">
        {{ $file->title }}
    </x-slot>
    <div class="relative min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4 overflow-hidden">
        <!-- Decorative SVG shapes for background -->
        <svg class="absolute top-0 left-0 w-80 h-80 opacity-20 pointer-events-none" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" fill="#5B88B2"/>
        </svg>
        <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10 pointer-events-none" viewBox="0 0 200 200">
            <rect width="200" height="200" rx="100" fill="#FBF9E4"/>
        </svg>

        <div class="relative max-w-3xl mx-auto space-y-8">
            <!-- File Info Card -->
            <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-2xl p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-extrabold text-[#FBF9E4] mb-2 flex items-center gap-2">
                            <svg class="w-7 h-7 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16V8a2 2 0 012-2h4l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2z" />
                            </svg>
                            {{ $file->title ?? $file->filename }}
                        </h1>
                        <p class="text-[#5B88B2] text-sm mb-1">Owner: <span class="text-[#FBF9E4]">{{ $file->user->name }}</span></p>
                        <p class="text-[#5B88B2] text-sm mb-1">Created: <span class="text-[#FBF9E4]">{{ $file->created_at->format('M d, Y H:i') }}</span></p>
                        <p class="text-[#5B88B2] text-sm mb-1">Updated: <span class="text-[#FBF9E4]">{{ $file->updated_at->format('M d, Y H:i') }}</span></p>
                        <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full
                            {{ $file->is_public
                                ? 'bg-[#22543d]/80 border border-[#38a169] text-[#BFD7ED]'
                                : 'bg-[#4a232e]/80 border border-[#e53e3e] text-[#BFD7ED]' }}
                            font-bold">
                            {{ $file->is_public ? 'Public' : 'Private' }}
                        </span>
                    </div>
                    <div class="flex flex-col gap-2 md:items-end">
                        <a href="{{ route('file.index') }}" class="bg-[#5B88B2] text-[#FBF9E4] px-4 py-2 rounded-lg font-semibold shadow hover:bg-[#49709a] transition text-center">Back to files</a>
                        @can('update', $file)
                            <a href="{{ route('file.edit', $file->id) }}" class="bg-[#5B88B2] text-[#FBF9E4] px-4 py-2 rounded-lg font-semibold shadow hover:bg-[#49709a] transition text-center">Edit file</a>
                        @endcan
                        @can('delete', $file)
                            <a href="{{ route('files.manageAccess', $file->id) }}" class="bg-[#5B88B2] text-[#FBF9E4] px-4 py-2 rounded-lg font-semibold shadow hover:bg-[#49709a] transition text-center">Manage Access</a>
                            <form action="{{ route('file.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#4a232e]/80 border border-[#e53e3e] text-[#BFD7ED] px-4 py-2 rounded-lg font-semibold hover:bg-[#6e2a3a]/90 transition w-full mt-1">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-[#FBF9E4] mb-2"><span class="font-semibold text-[#5B88B2]">Filename:</span> {{ $file->filename }}</p>
                    <p class="text-[#BFD7ED] italic mb-2"><span class="font-semibold text-[#5B88B2] not-italic">Description:</span> {{ $file->description ?? 'No description.' }}</p>
                </div>
                <div class="mb-4">
                    <form action="{{ route('files.checkPassword', $file) }}" method="POST" class="flex flex-col md:flex-row md:items-center gap-3">
                        @csrf
                        <label for="password" class="text-[#5B88B2] font-semibold">Enter Password to Download:</label>
                        <input type="password" name="password" id="password" required class="border border-[#5B88B2] rounded-lg p-2 bg-[#122C4F] text-[#FBF9E4] focus:ring-2 focus:ring-[#5B88B2] focus:outline-none placeholder-[#FBF9E4]/60" placeholder="Password">
                        <button type="submit" class="bg-[#5B88B2] text-[#FBF9E4] px-4 py-2 rounded-lg font-semibold shadow hover:bg-[#49709a] transition">Download</button>
                    </form>
                </div>
                @if (session('success'))
                    <div class="bg-green-900/80 text-[#BFD7ED] p-4 rounded mb-4 border border-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-[#4a232e]/80 text-[#BFD7ED] p-4 rounded mb-4 border border-[#e53e3e]">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Comments Section -->
            <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-2xl p-8">
                <h2 class="text-2xl font-bold text-[#FBF9E4] mb-4">Comments</h2>
                <form action="{{ route('comments.store', $file->id) }}" method="POST" class="mb-6">
                    @csrf
                    <div class="mb-3">
                        <label for="content" class="block text-[#5B88B2] font-semibold mb-1">Add a Comment:</label>
                        <textarea name="content" id="content" rows="3" required class="w-full border border-[#5B88B2] rounded-lg p-2 bg-[#122C4F] text-[#FBF9E4] focus:ring-2 focus:ring-[#5B88B2] focus:outline-none placeholder-[#FBF9E4]/60"></textarea>
                    </div>
                    <button type="submit" class="bg-[#5B88B2] text-[#FBF9E4] px-4 py-2 rounded-lg font-semibold shadow hover:bg-[#49709a] transition">Submit Comment</button>
                </form>
                @foreach ($file->comments as $comment)
                    <div class="border border-[#5B88B2] bg-[#122C4F]/80 rounded-lg p-4 mb-4 flex justify-between items-start gap-4">
                        <div>
                            <p class="font-bold text-[#5B88B2] mb-1">{{ $comment->users->name ?? 'User' }}</p>
                            <p class="text-[#FBF9E4]">{{ $comment->content }}</p>
                        </div>
                        @can('update', $comment)
                        <div class="flex gap-2">
                            <form action="{{ route('comments.edit', $comment->id) }}" method="GET">
                                <button type="submit" class="bg-[#5B88B2] text-[#FBF9E4] px-3 py-1 text-xs rounded hover:bg-[#49709a] transition">Edit</button>
                            </form>
                            @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#4a232e]/80 border border-[#e53e3e] text-[#BFD7ED] px-3 py-1 text-xs rounded hover:bg-[#6e2a3a]/90 transition">Delete</button>
                            </form>
                            @endcan
                        </div>
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>