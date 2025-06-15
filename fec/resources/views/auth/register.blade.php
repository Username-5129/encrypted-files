<x-layout>
    <x-slot name="title">
        Register
    </x-slot>
    <div class="flex items-center justify-center min-h-screen bg-[#122C4F]">
        <div class="w-full max-w-md bg-[#FBF9E4] rounded-2xl shadow-xl p-8">
            <h1 class="text-2xl font-bold mb-6 text-center text-[#122C4F]">Register</h1>
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-[#122C4F] mb-1">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-800"
                        required
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-[#122C4F] mb-1">Email address</label>
                    <input
                        type="email"
                        name="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-800"
                        required
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-[#122C4F] mb-1">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-800"
                        required
                    >
                    @error('password')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-[#122C4F] mb-1">Password confirmation</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-800"
                        required
                    >
                    @error('password_confirmation')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-[#5B88B2] text-white font-semibold rounded-2xl shadow-md hover:bg-[#49709a] transition">Register</button>
            </form>
        </div>
    </div>
</x-layout>