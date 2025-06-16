<x-layout>
    <x-slot name="title">
        Friends
    </x-slot>

    <div class="relative min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4 overflow-hidden">
        <!-- Decorative SVG shapes for background -->
        <svg class="absolute top-0 left-0 w-80 h-80 opacity-20 pointer-events-none" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" fill="#5B88B2"/>
        </svg>
        <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10 pointer-events-none" viewBox="0 0 200 200">
            <rect width="200" height="200" rx="100" fill="#FBF9E4"/>
        </svg>

        <div class="relative max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Friends List -->
            <div class="lg:col-span-2">
                <h1 class="text-3xl font-extrabold mb-8 text-[#FBF9E4]">My Friends</h1>
                @if(session('success'))
                    <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if($friends->isEmpty())
                    <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] text-[#FBF9E4] px-4 py-6 rounded-2xl shadow-xl text-center">
                        You have no friends yet.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($friends as $friend)
                            <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] shadow-xl rounded-2xl p-6 flex justify-between items-center hover:scale-[1.02] transition-transform">
                                <div class="flex items-center gap-4">
                                    <div class="bg-[#5B88B2] text-[#FBF9E4] rounded-full w-12 h-12 flex items-center justify-center text-xl font-bold shadow">
                                        {{ strtoupper(substr($friend->username ?? $friend->email ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-[#FBF9E4] text-lg">{{ $friend->username ?? $friend->email ?? "User #{$friend->id}" }}</div>
                                        <div class="text-xs text-[#5B88B2]">{{ $friend->email }}</div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('friends.remove', $friend->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-[#4a232e]/80 border border-[#e53e3e] text-[#BFD7ED] px-3 py-1 text-xs rounded-md hover:bg-[#6e2a3a]/90 transition"
                                        style="min-width: 0;"
                                        onclick="return confirm('Are you sure you want to remove this friend?');">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Sidebar: Add Friend & Requests -->
            <div class="space-y-8">
                <!-- Add Friend -->
                <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-bold mb-4 text-[#FBF9E4]">Add Friend</h2>
                    <form method="POST" action="{{ route('friends.add') }}" class="flex flex-col gap-3">
                        @csrf
                        <input type="email" name="friend_email" placeholder="Friend's Email" required class="border border-[#5B88B2] rounded-lg p-2 bg-[#122C4F] text-[#FBF9E4] focus:ring-2 focus:ring-[#5B88B2] focus:outline-none placeholder-[#FBF9E4]/60" />
                        <button type="submit" class="bg-[#5B88B2] text-[#FBF9E4] font-semibold py-2 rounded-lg hover:bg-[#49709a] transition">
                            Add Friend
                        </button>
                    </form>
                </div>

                <!-- Friend Requests -->
                <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-bold mb-4 text-[#FBF9E4]">Friend Requests</h2>
                    @if($friendRequests->isEmpty())
                        <p class="text-[#FBF9E4]/80">No pending friend requests.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach($friendRequests as $request)
                                <li class="flex justify-between items-center bg-[#122C4F] rounded-lg p-3">
                                    <span class="text-[#FBF9E4]">{{ $request->sender->email }}</span>
                                    <form action="{{ route('friends.respond', $request->id) }}" method="POST" class="flex space-x-2">
                                        @csrf
                                        <button name="action" value="accept" type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Accept</button>
                                        <button name="action" value="decline" type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Decline</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>