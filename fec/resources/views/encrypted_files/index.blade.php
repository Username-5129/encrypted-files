<x-layout>
    <x-slot name="title">
        Files
    </x-slot>
    <h1>Welcome to the Encrypted Files section!</h1>
    <a href="{{ route('file.create') }}" class="text-black font-semibold text-xl relative after:block after:h-0.5 after:bg-[#5B88B2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300 after:origin-left">Create Files</a>
    
    <h2 class="mt-8 mb-4 text-2xl font-bold">Your Encrypted Files</h2>
    @if ($userFiles->count())
        <div class="flex flex-wrap -mx-4">
            @foreach ($userFiles as $file)
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-6">
                    <x-file-card :file="$file" />
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-blue-100 text-blue-800 px-4 py-3 rounded">
            No files available.
        </div>
    @endif

    <h2 class="mt-8 mb-4 text-2xl font-bold">Public Encrypted Files</h2>
    @if ($publicFiles->count())
        <div class="flex flex-wrap -mx-4">
            @foreach ($publicFiles as $file)
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-6">
                    <x-file-card :file="$file" />
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-blue-100 text-blue-800 px-4 py-3 rounded">
            No public files available.
        </div>
    @endif
</x-layout>