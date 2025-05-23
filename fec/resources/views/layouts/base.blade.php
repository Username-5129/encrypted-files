<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My Website')</title>
    <!-- Add your CSS and meta tags here -->
</head>
<body>
    <nav>
        <!-- Your navbar HTML here -->
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/files">Files</a>
        <a href="/login">Login</a> <!-- This should be a link to the login page -->
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>