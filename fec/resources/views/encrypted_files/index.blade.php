<x-layout>
    <x-slot name="title">
        Files
    </x-slot>
    <div class="relative min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4 overflow-hidden">
        <!-- Decorative SVG shapes for background -->
        <svg class="absolute top-0 left-0 w-80 h-80 opacity-20 pointer-events-none" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" fill="#5B88B2"/>
        </svg>
        <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10 pointer-events-none" viewBox="0 0 200 200">
            <rect width="200" height="200" rx="100" fill="#FBF9E4"/>
        </svg>

        <div class="relative max-w-7xl mx-auto space-y-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
                <h1 class="text-3xl font-extrabold text-[#FBF9E4] mb-4 md:mb-0">Encrypted Files</h1>
                <a href="{{ route('file.create') }}"
                   class="inline-block bg-[#5B88B2] text-[#FBF9E4] font-semibold px-6 py-2 rounded-lg shadow hover:bg-[#49709a] transition text-lg">
                    + Create New File
                </a>
            </div>

            @auth
            <div class="bg-[#1e3a5c]/80 border border-[#5B88B2] rounded-2xl shadow-xl p-8">
                <h2 class="mb-6 text-2xl font-bold text-[#FBF9E4] flex items-center gap-2">
                    <svg class="w-6 h-6 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16V8a2 2 0 012-2h4l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2z" />
                    </svg>
                    Your Encrypted Files
                </h2>
                @if ($userFiles->count())
                    <div class="flex flex-wrap -mx-4">
                        @foreach ($userFiles as $file)
                            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-6">
                                <x-file-card :file="$file" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-[#FBF9E4] text-[#122C4F] px-4 py-3 rounded shadow text-center">
                        No files available.
                    </div>
                @endif
            </div>
            @endauth

            <div class="bg-[#1e3a5c]/80 border border-[#5B88B2] rounded-2xl shadow-xl p-8">
                <h2 class="mb-6 text-2xl font-bold text-[#FBF9E4] flex items-center gap-2">
                    <svg class="w-6 h-6 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Public Encrypted Files
                </h2>
                @if ($publicFiles->count())
                    <div class="flex flex-wrap -mx-4">
                        @foreach ($publicFiles as $file)
                            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-6">
                                <x-file-card :file="$file" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-[#FBF9E4] text-[#122C4F] px-4 py-3 rounded shadow text-center">
                        No public files available.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>