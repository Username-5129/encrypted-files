<x-layout>
    <x-slot name="title">
        Edit Comment
    </x-slot>
    <div class="relative min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4 overflow-hidden flex items-center justify-center">
        <svg class="absolute top-0 left-0 w-80 h-80 opacity-20 pointer-events-none" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" fill="#5B88B2"/>
        </svg>
        <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10 pointer-events-none" viewBox="0 0 200 200">
            <rect width="200" height="200" rx="100" fill="#FBF9E4"/>
        </svg>

        <div class="w-full max-w-lg bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-2xl p-8 relative">
            <h1 class="text-2xl font-bold text-[#FBF9E4] mb-6 text-center">Edit Comment</h1>
            <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label for="content" class="block text-sm font-medium text-[#FBF9E4] mb-1">Comment:</label>
                    <textarea name="content" id="content" rows="4" required
                        class="block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60">{{ $comment->content }}</textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ url()->previous() }}"
                        class="bg-[#5B88B2] text-[#FBF9E4] px-4 py-2 rounded-lg font-semibold shadow hover:bg-[#49709a] transition">Cancel</a>
                    <button type="submit"
                        class="bg-[#5B88B2] text-[#FBF9E4] px-4 py-2 rounded-lg font-semibold shadow hover:bg-[#49709a] transition">Update Comment</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>