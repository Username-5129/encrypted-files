<x-layout>
    <x-slot name="title">
        Files
    </x-slot>
    <h1>Welcome to the Encrypted Files section!</h1>

    @if ($files->count())
        <div class="flex flex-wrap -mx-4">
            @foreach ($files as $file)
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

</x-layout>