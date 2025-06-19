<x-layout>
    <x-slot name="title">
        Register
    </x-slot>
    <div class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4 overflow-hidden">
        <svg class="absolute top-0 left-0 w-80 h-80 opacity-20 pointer-events-none" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" fill="#5B88B2"/>
        </svg>
        <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10 pointer-events-none" viewBox="0 0 200 200">
            <rect width="200" height="200" rx="100" fill="#FBF9E4"/>
        </svg>

        <div class="w-full max-w-md bg-[#1e3a5c]/90 p-8 rounded-2xl shadow-2xl border border-[#5B88B2] relative">
            <h1 class="mb-4 text-2xl font-bold text-[#FBF9E4] text-center">Register</h1>
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-[#FBF9E4]">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60"
                        required
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <small class="text-red-400">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-[#FBF9E4]">Email address</label>
                    <input
                        type="email"
                        name="email"
                        class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60"
                        required
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <small class="text-red-400">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-[#FBF9E4]">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60"
                        required
                    >
                    @error('password')
                        <small class="text-red-400">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-[#FBF9E4]">Password confirmation</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="mt-1 block w-full border-[#5B88B2] rounded-lg shadow-sm focus:ring-2 focus:ring-[#5B88B2] focus:outline-none p-2 bg-[#122C4F] text-[#FBF9E4] placeholder-[#FBF9E4]/60"
                        required
                    >
                    @error('password_confirmation')
                        <small class="text-red-400">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="mt-4 w-full bg-[#5B88B2] text-[#FBF9E4] font-bold py-2 px-4 rounded-lg hover:bg-[#49709a] transition">Register</button>
            </form>
        </div>
    </div>
</x-layout>