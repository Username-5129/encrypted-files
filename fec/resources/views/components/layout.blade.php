<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <title>{{ $title }}</title>

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex flex-col bg-black">
    <main class="flex-1">
        <x-navbar />
        {{ $slot }}
    </main>
    <footer class="bg-black w-full h-28 flex items-center justify-center mt-10">
        <span class="text-white text-lg">&copy; {{ date('Y') }} Fec. All rights reserved.</span>
    </footer>
    @vite(['resources/js/app.js'])
</body>
</html>
