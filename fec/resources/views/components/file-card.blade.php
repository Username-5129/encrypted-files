<div class="relative bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-xl p-6 flex flex-col h-full overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-200 group">
    <!-- Decorative blue accent -->
    <div class="absolute -top-4 -right-4 w-20 h-20 bg-gradient-to-br from-[#5B88B2]/40 to-transparent rounded-full blur-2xl opacity-60 pointer-events-none"></div>

    <div class="flex items-center gap-3 mb-4">
        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#27446b] flex items-center justify-center text-[#BFD7ED] font-bold text-2xl shadow-lg group-hover:scale-110 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="#BFD7ED">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16V8a2 2 0 012-2h4l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <h3 class="text-xl font-extrabold text-[#FBF9E4] truncate">{{ $file->filename ?? 'Untitled File' }}</h3>
            <span class="text-xs text-[#5B88B2]">{{ $file->created_at->format('M d, Y') }}</span>
        </div>
        @if($file->is_public)
            <span class="px-2 py-1 text-xs rounded-full bg-[#22543d]/80 border border-[#38a169] text-[#BFD7ED] font-bold flex items-center gap-1 shadow">
                <svg class="w-4 h-4" fill="none" stroke="#38a169" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Public
            </span>
        @else
            <span class="px-2 py-1 text-xs rounded-full bg-[#4a232e]/80 border border-[#e53e3e] text-[#BFD7ED] font-bold flex items-center gap-1 shadow">
                <svg class="w-4 h-4" fill="none" stroke="#e53e3e" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m0-6v2m-6 4V7a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2z" />
                </svg>
                Private
            </span>
        @endif
    </div>
    <p class="text-[#BFD7ED] text-base mb-6 italic line-clamp-3">{{ $file->description ?? 'No description.' }}</p>
    <div class="flex justify-end gap-2 mt-auto">
        <a href="{{ route('files.show', $file->id) }}"
           class="bg-[#5B88B2] text-[#FBF9E4] px-5 py-2 rounded-xl text-base font-bold shadow hover:bg-[#49709a] transition">
            View
        </a>
    </div>
</div>
