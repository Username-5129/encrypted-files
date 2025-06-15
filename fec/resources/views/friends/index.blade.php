<x-layout>
    <x-slot name="title">
        Friends
    </x-slot>

    <h1 class="text-2xl font-bold mb-6">My Friends</h1>

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
        <div class="flex flex-wrap -mx-4 mb-6">
            @foreach($friends as $friend)
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-4">
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h2 class="font-semibold">{{ $friend->username ?? $friend->email ?? "User  #{$friend->id}" }}</h2>
                        {{-- Optional: Add Remove button/link for each friend --}}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('friends.add') }}" class="flex items-center mb-6">
        @csrf
        <input type="email" name="friend_email" placeholder="Friend's Email" required class="border border-gray-300 rounded-lg p-2 flex-grow mr-2" />
        <button type="submit" class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition duration-200">
            Add Friend
        </button>
    </form>

    <h2 class="text-xl font-semibold mb-4">Friend Requests</h2>

    @if($friendRequests->isEmpty())
        <p>No pending friend requests.</p>
    @else
        <ul>
            @foreach($friendRequests as $request)
                <li class="mb-3 p-3 border rounded flex justify-between items-center bg-gray-50 dark:bg-gray-800">
                    <span>{{ $request->sender->email }}</span>
                    <form action="{{ route('friends.respond', $request->id) }}" method="POST" class="flex space-x-2">
                        @csrf
                        <button name="action" value="accept" type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Accept</button>
                        <button name="action" value="decline" type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Decline</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</x-layout>