<x-layout>
    <x-slot name="title">
        Manage Access for {{ $file->filename }}
    </x-slot>

    <div class="relative min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4 overflow-hidden">

        <svg class="absolute top-0 left-0 w-80 h-80 opacity-20 pointer-events-none" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" fill="#5B88B2"/>
        </svg>
        <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10 pointer-events-none" viewBox="0 0 200 200">
            <rect width="200" height="200" rx="100" fill="#FBF9E4"/>
        </svg>

        <div class="relative max-w-3xl mx-auto mt-16">
            <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-2xl p-10">
                <h1 class="text-3xl font-extrabold text-[#FBF9E4] mb-8 flex items-center gap-2">
                    <svg class="w-7 h-7 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"/>
                    </svg>
                    Manage Access for {{ $file->filename }}
                </h1>

                <div class="mb-8">
                    <h2 class="text-xl font-bold text-[#BFD7ED] mb-4">Users with Access:</h2>
                    <ul class="space-y-4">
                        @foreach ($usersWithAccess as $access)
                            <li class="flex flex-col md:flex-row md:items-center justify-between bg-[#122C4F]/80 border border-[#5B88B2]/40 rounded-lg px-5 py-4 mb-2">
                                <div class="text-[#FBF9E4] font-medium">
                                    {{ $access->users->name }} <span class="text-[#BFD7ED]">({{ $access->users->email }})</span>
                                </div>
                                <div class="flex gap-2 mt-2 md:mt-0">
                                    <form action="{{ route('files.toggleEdit', [$file->id, $access->users->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 rounded-lg font-semibold shadow bg-yellow-400 text-[#122C4F] hover:bg-yellow-300 transition">
                                            {{ $access->can_edit ? 'Disable Editing' : 'Enable Editing' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('files.removeAccess', [$file->id, $access->users->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 rounded-lg font-semibold shadow bg-red-500 text-[#FBF9E4] hover:bg-red-400 transition">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-bold text-[#BFD7ED] mb-4">Friends without Access:</h2>
                    <ul class="space-y-4">
                        @foreach ($friendsWithoutAccess as $friend)
                            <li class="flex flex-col md:flex-row md:items-center justify-between bg-[#122C4F]/80 border border-[#5B88B2]/40 rounded-lg px-5 py-4 mb-2">
                                <div class="text-[#FBF9E4] font-medium">
                                    {{ $friend->name }} <span class="text-[#BFD7ED]">({{ $friend->email }})</span>
                                </div>
                                <div class="mt-2 md:mt-0">
                                    <form action="{{ route('files.addAccess', [$file->id, $friend->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 rounded-lg font-semibold shadow bg-[#5B88B2] text-[#FBF9E4] hover:bg-[#49709a] transition">
                                            Grant Access
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <a href="{{ route('files.show', $file->id) }}"
                   class="inline-block mt-4 bg-[#5B88B2] text-[#FBF9E4] px-6 py-2 rounded-xl shadow hover:bg-[#49709a] transition font-semibold">
                    Back to File
                </a>
            </div>
        </div>
    </div>
</x-layout>