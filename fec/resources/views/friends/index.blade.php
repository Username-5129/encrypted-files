<x-layout>
    <x-slot name="title">
        Friends
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10">
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
                    <div class="bg-blue-100 text-blue-800 px-4 py-3 rounded mb-4">
                        You have no friends yet.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($friends as $friend)
                            <div class="bg-white/90 shadow-lg rounded-2xl p-6 flex justify-between items-center hover:scale-[1.02] transition-transform">
                                <div class="flex items-center gap-4">
                                    <div class="bg-[#5B88B2] text-[#FBF9E4] rounded-full w-12 h-12 flex items-center justify-center text-xl font-bold shadow">
                                        {{ strtoupper(substr($friend->username ?? $friend->email ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-[#122C4F] text-lg">{{ $friend->username ?? $friend->email ?? "User #{$friend->id}" }}</div>
                                        <div class="text-xs text-gray-500">{{ $friend->email }}</div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('friends.remove', $friend->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition"
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
                <div class="bg-[#FBF9E4] rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-[#122C4F]">Add Friend</h2>
                    <form method="POST" action="{{ route('friends.add') }}" class="flex flex-col gap-3">
                        @csrf
                        <input type="email" name="friend_email" placeholder="Friend's Email" required class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[#5B88B2] focus:outline-none" />
                        <button type="submit" class="bg-[#5B88B2] text-[#FBF9E4] font-semibold py-2 rounded-lg hover:bg-[#49709a] transition">
                            Add Friend
                        </button>
                    </form>
                </div>

                <!-- Friend Requests -->
                <div class="bg-[#FBF9E4] rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-[#122C4F]">Friend Requests</h2>
                    @if($friendRequests->isEmpty())
                        <p class="text-[#122C4F]">No pending friend requests.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach($friendRequests as $request)
                                <li class="flex justify-between items-center bg-gray-50 rounded-lg p-3">
                                    <span class="text-[#122C4F]">{{ $request->sender->email }}</span>
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