<nav>
  <div id="navbarSupportedContent">
    <ul>
      <li>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('about') }}">About</a>
        <a href="{{ route('files.index') }}">Files</a>
      </li>
      @auth
        <li>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
          </form>
        </li>
      @endauth
      @guest
        <li>
          <a href="{{ route('register') }}">Register</a>
        </li>
        <li>
          <a href="{{ route('login') }}">Login</a>
        </li>
      @endguest
    </ul>
  </div>
</nav>