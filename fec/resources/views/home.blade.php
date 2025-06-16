<x-layout>
    <x-slot name="title">
        Home
    </x-slot>
    @auth
    <section class="relative min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4 overflow-hidden">
        <!-- Decorative SVG shapes for background -->
        <svg class="absolute top-0 left-0 w-80 h-80 opacity-20 pointer-events-none" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" fill="#5B88B2"/>
        </svg>
        <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10 pointer-events-none" viewBox="0 0 200 200">
            <rect width="200" height="200" rx="100" fill="#FBF9E4"/>
        </svg>

        <div class="relative max-w-6xl mx-auto space-y-10">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-4xl font-extrabold text-[#FBF9E4] mb-2">Welcome, {{ Auth::user()->name ?? 'User' }}!</h2>
                    <p class="text-[#5B88B2] text-lg italic">
                        Tip: This homepage is customizable — click <span class="underline font-semibold">Customize</span> to edit what you see here. <span class="ml-1 align-middle"span>
                    </p>
                </div>
                <button onclick="document.getElementById('settings-modal').classList.remove('hidden')" class="bg-[#5B88B2] text-[#FBF9E4] px-6 py-2 rounded-xl shadow-lg hover:bg-[#49709a] transition text-base font-semibold">
                    <svg class="inline-block w-5 h-5 mr-2 -mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Customize
                </button>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Recent Files -->
                <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-2xl p-8 flex flex-col">
                    <h3 class="font-bold text-2xl text-[#FBF9E4] mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16V8a2 2 0 012-2h4l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2z" />
                        </svg>
                        Recent Files
                    </h3>
                    @if($recentFiles->isEmpty())
                        <p class="text-[#FBF9E4]/80">No recent files.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($recentFiles as $file)
                                <li class="flex items-center justify-between bg-[#122C4F] rounded-lg px-4 py-2 shadow">
                                    <div>
                                        <a href="{{ route('files.show', $file->id) }}" class="text-[#FBF9E4] font-semibold hover:underline">{{ $file->filename }}</a>
                                        <span class="text-xs text-[#5B88B2] ml-2">{{ $file->created_at->diffForHumans() }}</span>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded-full
                                        {{ $file->is_public
                                            ? 'bg-[#22543d]/80 border border-[#38a169] text-[#BFD7ED]'
                                            : 'bg-[#4a232e]/80 border border-[#e53e3e] text-[#BFD7ED]' }}
                                        font-bold">
                                        {{ $file->is_public ? 'Public' : 'Private' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Friends Activity -->
                <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-2xl p-8 flex flex-col">
                    <h3 class="font-bold text-2xl text-[#FBF9E4] mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-5a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Friends Activity
                    </h3>
                    @if($friends->isEmpty())
                        <p class="text-[#FBF9E4]/80">No friends yet, so no activity to show.</p>
                    @elseif($friendActivity->isEmpty())
                        <p class="text-[#FBF9E4]/80">No recent activity from your friends.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($friendActivity as $activity)
                                <li class="bg-[#122C4F] rounded-lg px-4 py-2 shadow text-[#FBF9E4]">
                                    <span class="font-bold text-[#5B88B2]">{{ $activity->user->name ?? $activity->user->email }}</span>
                                    {{ $activity->description }}
                                    <span class="text-xs text-[#5B88B2] ml-2">{{ $activity->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Settings Modal -->
        <div id="settings-modal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
            <div class="bg-[#FBF9E4] rounded-2xl shadow-2xl p-8 w-full max-w-md border border-[#5B88B2]">
                <h2 class="text-xl font-bold mb-4 text-[#122C4F]">Customize Homepage</h2>
                <form method="POST" action="{{ route('homepage.settings.update') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="flex items-center gap-2 text-[#122C4F]">
                            <input type="checkbox" name="show_recent_files" {{ $settings->show_recent_files ? 'checked' : '' }}>
                            Show Recent Files
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center gap-2 text-[#122C4F]">
                            <input type="checkbox" name="show_friend_activity" {{ $settings->show_friend_activity ? 'checked' : '' }}>
                            Show Friends Activity
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-[#122C4F]">Theme</label>
                        <select name="theme" class="rounded border-[#5B88B2] focus:ring-2 focus:ring-[#5B88B2]">
                            <option value="light" {{ $settings->theme === 'light' ? 'selected' : '' }}>Light</option>
                            <option value="dark" {{ $settings->theme === 'dark' ? 'selected' : '' }}>Dark</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-[#122C4F]">Layout</label>
                        <select name="layout" class="rounded border-[#5B88B2] focus:ring-2 focus:ring-[#5B88B2]">
                            <option value="grid" {{ $settings->layout === 'grid' ? 'selected' : '' }}>Grid</option>
                            <option value="list" {{ $settings->layout === 'list' ? 'selected' : '' }}>List</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('settings-modal').classList.add('hidden')" class="px-4 py-2 rounded bg-gray-200 text-[#122C4F]">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-[#5B88B2] text-[#FBF9E4] font-semibold">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        // Simple modal close on ESC
        document.addEventListener('keydown', function(e) {
            if(e.key === "Escape") {
                document.getElementById('settings-modal').classList.add('hidden');
            }
        });
    </script>
    @endauth
</x-layout>

