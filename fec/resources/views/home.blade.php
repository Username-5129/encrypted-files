<x-layout>
    <x-slot name="title">
        Home
    </x-slot>
    @auth
    <section class="min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4">
        <div class="max-w-5xl mx-auto space-y-8">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-extrabold text-[#FBF9E4]">Your Homepage</h2>
                <button onclick="document.getElementById('settings-modal').classList.remove('hidden')" class="bg-[#5B88B2] text-[#FBF9E4] px-4 py-2 rounded-lg shadow hover:bg-[#49709a] transition text-sm font-semibold">
                    Edit Homepage
                </button>
            </div>

            @if($settings->show_recent_files)
            <div class="bg-[#FBF9E4] rounded-2xl shadow-lg p-6">
                <h3 class="font-bold text-xl text-[#122C4F] mb-4">Recent Files</h3>
                @if($recentFiles->isEmpty())
                    <p class="text-[#122C4F]">No recent files.</p>
                @else
                    <ul>
                        @foreach($recentFiles as $file)
                            <li class="text-[#122C4F]">
                                <a href="{{ route('files.show', $file->id) }}" class="underline">{{ $file->name }}</a>
                                <span class="text-xs text-gray-500 ml-2">{{ $file->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            @endif

            @if($settings->show_friend_activity)
            <div class="bg-[#FBF9E4] rounded-2xl shadow-lg p-6">
                <h3 class="font-bold text-xl text-[#122C4F] mb-4">Friends Activity</h3>
                @if($friends->isEmpty())
                    <p class="text-[#122C4F]">No friends yet, so no activity to show.</p>
                @elseif($friendActivity->isEmpty())
                    <p class="text-[#122C4F]">No recent activity from your friends.</p>
                @else
                    <ul>
                        @foreach($friendActivity as $activity)
                            <li class="text-[#122C4F]">
                                <span class="font-bold">{{ $activity->user->name ?? $activity->user->email }}</span>
                                {{ $activity->description }}
                                <span class="text-xs text-gray-500 ml-2">{{ $activity->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            @endif
        </div>

        <!-- Settings Modal -->
        <div id="settings-modal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4 text-[#122C4F]">Customize Homepage</h2>
                <form method="POST" action="{{ route('homepage.settings.update') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="show_recent_files" {{ $settings->show_recent_files ? 'checked' : '' }}>
                            Show Recent Files
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="show_friend_activity" {{ $settings->show_friend_activity ? 'checked' : '' }}>
                            Show Friends Activity
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-[#122C4F]">Theme</label>
                        <select name="theme" class="rounded border-gray-300">
                            <option value="light" {{ $settings->theme === 'light' ? 'selected' : '' }}>Light</option>
                            <option value="dark" {{ $settings->theme === 'dark' ? 'selected' : '' }}>Dark</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-[#122C4F]">Layout</label>
                        <select name="layout" class="rounded border-gray-300">
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

