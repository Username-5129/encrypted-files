<x-layout>
    <x-slot name="title">
        Login
    </x-slot>
    <div class="relative flex items-center justify-center min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black overflow-hidden">
        <!-- Decorative SVG shapes for background -->
        <div class="absolute inset-0 pointer-events-none">
            <svg class="absolute top-0 left-0 w-80 h-80 opacity-20" viewBox="0 0 200 200"><circle cx="100" cy="100" r="100" fill="#5B88B2"/></svg>
            <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10" viewBox="0 0 200 200"><rect width="200" height="200" rx="100" fill="#FBF9E4"/></svg>
        </div>
        <div class="w-full max-w-md bg-[#FBF9E4] rounded-2xl shadow-xl p-8 relative z-10">
            <h1 class="text-2xl font-bold mb-6 text-center text-[#122C4F]">Login</h1>
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-[#122C4F] mb-1">Email address</label>
                    <input
                        type="email"
                        name="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-800"
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-800"
                        required
                    >
                    @error('password')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-[#5B88B2] text-white font-semibold rounded-2xl shadow-md hover:bg-[#49709a] transition">Login</button>
            </form>
        </div>
    </div>
</x-layout>