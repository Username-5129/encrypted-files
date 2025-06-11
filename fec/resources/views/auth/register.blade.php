<x-layout>
    <x-slot name="title">
        Register
    </x-slot>
        <h1>Register</h1>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input
                type="text"
                name="name"
                class="form-control"
                required
                value="{{ old('name') }}"
            >
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input
                type="email"
                name="email"
                class="form-control"
                required
                value="{{ old('email') }}"
            >
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                required
                value=""
            >
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Password confirmation</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                required
                value=""
            >
            @error('password_confirmation')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
            <button type="submit" class="btn btn-primary">Register</button>

    </form>
</x-layout>