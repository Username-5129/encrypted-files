<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My Website')</title>
    <!-- Add your CSS and meta tags here -->
    @vite('resources/css/app.css')
</head>
<body>
    <nav>
        <!-- Your navbar HTML here -->
        <a href="/">Home 1</a>
        <a href="/about">About</a>
        <a href="/files">Files</a>
        <a href="/login">Login</a> <!-- This should be a link to the login page -->
    </nav>
    <h1 class=" underline">
        HEELO WORLD!
</h1>
    
    <div class="container">
        @yield('content')
    </div>
</body>
</html>