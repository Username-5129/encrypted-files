<x-layout>
    <x-slot name="title">
        Files
    </x-slot>
    <h1>Welcome to the Encrypted Files section!</h1>
    @can('create', App\Models\File::class)
        <a class="text-green-500">You are authenticated!</a>
    @endcan

    @guest
    <a class="text-red-500">You are not logged in!</a>
    @endguest
</x-layout>