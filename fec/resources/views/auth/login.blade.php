<x-layout>
    <x-slot name="title">
        Login
    </x-slot>
    <div class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
            <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
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
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
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
                <button type="submit" class="w-full py-2 px-4 bg-green-800 text-white font-semibold rounded-2xl shadow-md hover:bg-green-900 transition">Login</button>
            </form>
        </div>
    </div>
</x-layout>