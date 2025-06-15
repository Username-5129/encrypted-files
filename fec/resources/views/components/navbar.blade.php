<nav class="bg-gradient-to-b from-black/90 to-[#122C4F]/90 backdrop-blur border-b border-[#5B88B2]/30 shadow-lg sticky top-0 z-50">
  <div class="w-full px-8 sm:px-16">
    <div class="flex justify-between h-20 items-center">
      <!-- Left side: Logo and links -->
      <div class="flex items-center">
        <a href="/">
          <img src="/fec-logo-2.png" alt="Logo" class="h-12 w-auto">
        </a>
        <div class="flex items-center space-x-10 ml-20">
          <a href="{{ route('files.index') }}" class="text-white font-semibold text-xl relative after:block after:h-0.5 after:bg-[#5B88B2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300 after:origin-left">Files</a>
          @auth
          <a href="{{ route('friends.index') }}" class="text-white font-semibold text-xl relative after:block after:h-0.5 after:bg-[#5B88B2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300 after:origin-left">Friends</a>
           @endauth
        </div>
      </div>
      <!-- Right side: Auth links -->
      <div class="flex items-center space-x-4">
        @guest
        <a href="{{ route('register') }}" class="text-[#122C4F] font-semibold text-lg rounded-full px-6 py-3 border border-gray-200 transition-shadow hover:shadow-xl bg-[#FBF9E4] hover:bg-[#f3f1db]">Register</a>
        <a href="{{ route('login') }}" class="text-[#122C4F] font-semibold text-lg rounded-full px-6 py-3 border border-gray-200 transition-shadow hover:shadow-xl bg-[#FBF9E4] hover:bg-[#f3f1db]">Login</a>
        @endguest

        @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-[#122C4F] font-semibold text-lg rounded-full px-6 py-3 border border-gray-200 transition-shadow hover:shadow-xl bg-[#FBF9E4] hover:bg-[#f3f1db]">
                Logout
            </button>
        </form>
        @endauth
      </div>
    </div>
  </div>
</nav>