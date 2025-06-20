<nav class="bg-gradient-to-b from-black/90 to-[#122C4F]/90 backdrop-blur border-b border-[#5B88B2]/30 shadow-lg sticky top-0 z-50">
  <div class="w-full px-8 sm:px-16">
    <div class="flex justify-between h-20 items-center">
      <div class="flex items-center">
        <a href="{{ route('home') }}">
          <img src="/fec-logo-2.png" alt="Logo" class="h-12 w-auto">
        </a>
        <div class="flex items-center space-x-10 ml-20">
          <a href="{{ route('files.index') }}" class="text-white font-semibold text-xl relative after:block after:h-0.5 after:bg-[#5B88B2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300 after:origin-left">{{ __('navbar.files') }}</a>
          @auth
          <a href="{{ route('friends.index') }}" class="text-white font-semibold text-xl relative after:block after:h-0.5 after:bg-[#5B88B2] after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300 after:origin-left">{{ __('navbar.friends') }}</a>
          @endauth
        </div>
      </div>
      <div class="flex items-center space-x-4">

      <button id="clock" 
          class="text-[#122C4F] font-semibold text-lg rounded-full px-6 py-3 border border-gray-200 transition-shadow hover:shadow-xl bg-[#FBF9E4] hover:bg-[#f3f1db]">
          {{ __('navbar.click_to_get_time') }}
      </button>
      
        <details class="relative inline-block text-left">
          <summary class="cursor-pointer list-none inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
            {{ Config::get('languages')[App::getLocale()] }}
            <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.29l3.71-4.06a.75.75 0 011.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
            </svg>
          </summary>

          <div class="absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
            @foreach (Config::get('languages') as $lang => $language)
              @if ($lang != App::getLocale())
                <a href="{{ route('lang.switch', $lang) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  {{ $language }}
                </a>
              @endif
            @endforeach
          </div>
        </details>


        @guest
        <a href="{{ route('register') }}" class="text-[#122C4F] font-semibold text-lg rounded-full px-6 py-3 border border-gray-200 transition-shadow hover:shadow-xl bg-[#FBF9E4] hover:bg-[#f3f1db]">{{ __('navbar.register') }}</a>
        <a href="{{ route('login') }}" class="text-[#122C4F] font-semibold text-lg rounded-full px-6 py-3 border border-gray-200 transition-shadow hover:shadow-xl bg-[#FBF9E4] hover:bg-[#f3f1db]">{{ __('navbar.login') }}</a>
        @endguest

        @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-[#122C4F] font-semibold text-lg rounded-full px-6 py-3 border border-gray-200 transition-shadow hover:shadow-xl bg-[#FBF9E4] hover:bg-[#f3f1db]">
                {{ __('navbar.logout') }}
            </button>
        </form>
        @endauth
      </div>
    </div>
  </div>
</nav>