<x-layout>
    <x-slot name="title">
        Home
    </x-slot>
    @guest
    <!-- Hero Section -->
    <section class="relative flex flex-col items-center justify-center min-h-[60vh] bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <!-- Decorative SVG shapes for background -->
            <svg class="absolute top-0 left-0 w-80 h-80 opacity-20" viewBox="0 0 200 200"><circle cx="100" cy="100" r="100" fill="#5B88B2"/></svg>
            <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10" viewBox="0 0 200 200"><rect width="200" height="200" rx="100" fill="#FBF9E4"/></svg>
        </div>
        <div class="relative z-10 flex flex-col items-center">
            <img src="/fec-logo-2.png" alt="Logo" class="h-24 mb-6 drop-shadow-lg">
            <h1 class="text-5xl font-extrabold text-[#FBF9E4] mb-4 text-center drop-shadow-lg">Secure File Encryption & Sharing</h1>
            <p class="text-[#FBF9E4] text-xl mb-8 text-center max-w-2xl">
                Upload, encrypt, and securely share your files with friends or the public. Protect your data with strong encryption and manage access with ease.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
                <a href="/register" class="bg-[#5B88B2] hover:bg-[#49709a] text-[#FBF9E4] font-bold py-3 px-10 rounded-full shadow-lg transition text-lg text-center">Get Started</a>
                <a href="#about" class="bg-transparent hover:bg-[#FBF9E4] hover:text-[#122C4F] text-[#FBF9E4] font-bold py-3 px-10 rounded-full border-2 border-[#5B88B2] transition text-lg text-center">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-[#122C4F]">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8">
            <div class="bg-[#FBF9E4] rounded-2xl shadow-lg p-8 flex flex-col items-center hover:scale-105 hover:shadow-2xl transition-transform duration-300">
                <svg class="w-14 h-14 mb-4 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 2c-2.67 0-8 1.337-8 4v3h16v-3c0-2.663-5.33-4-8-4z"/></svg>
                <h3 class="font-bold text-2xl text-[#122C4F] mb-2">Private & Public Sharing</h3>
                <p class="text-[#122C4F] text-center">Share files privately with friends or publicly with a secure link. You control who sees your files.</p>
            </div>
            <div class="bg-[#FBF9E4] rounded-2xl shadow-lg p-8 flex flex-col items-center hover:scale-105 hover:shadow-2xl transition-transform duration-300">
                <svg class="w-14 h-14 mb-4 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 17a5 5 0 0 0 5-5V7a5 5 0 0 0-10 0v5a5 5 0 0 0 5 5zm0 0v2m0 0h-2m2 0h2"/></svg>
                <h3 class="font-bold text-2xl text-[#122C4F] mb-2">Strong Encryption</h3>
                <p class="text-[#122C4F] text-center">All files are encrypted with your password. Only those with the password can decrypt and download.</p>
            </div>
            <div class="bg-[#FBF9E4] rounded-2xl shadow-lg p-8 flex flex-col items-center hover:scale-105 hover:shadow-2xl transition-transform duration-300">
                <svg class="w-14 h-14 mb-4 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1"/></svg>
                <h3 class="font-bold text-2xl text-[#122C4F] mb-2">Activity & Logs</h3>
                <p class="text-[#122C4F] text-center">Track file activity, view logs, and comment on files. Admins can monitor for extra security.</p>
            </div>
        </div>
    </section>

    <!-- About Section (How does it work?) -->
    <section id="about" class="py-0" style="background: #5B88B2;">
        <div class="w-full px-0">
            <h2 class="w-full text-center pt-24 mb-20 text-7xl font-extrabold tracking-tight">
                <span 
                      style="color:  #122C4F; font-family: 'Playfair Display', 'Montserrat', 'Inter', sans-serif; letter-spacing: 2px; text-shadow: 0 4px 24px #0002;">
                    How does it work?
                </span>
            </h2>
            <div>
                <!-- Step 1: Image center, text below -->
                <div class="flex flex-col md:flex-row w-full items-center">
                    <div class="md:w-1/2 flex items-center justify-center min-h-[420px] bg-[#5B88B2] md:rounded-none rounded-t-3xl overflow-hidden relative">
                        <div class="absolute inset-0 w-full h-full bg-[#5B88B2]"></div>
                        <img src="/undraw_private-files_m2bw.svg" alt="Upload & Encrypt"
                             class="h-[320px] w-auto mx-auto object-contain relative z-10" style="border-radius:0;">
                    </div>
                    <div class="md:w-1/2 bg-[#FBF9E4] flex flex-col justify-center p-16 text-[#122C4F]">
                        <div class="max-w-2xl mx-auto flex flex-col">
                            <h3 class="font-bold text-4xl mb-8" style="font-family: 'Montserrat', 'Inter', sans-serif;">1. Upload & Encrypt</h3>
                            <p class="mb-6 text-2xl leading-snug">Easily upload any file type to our secure platform. When you upload, you set a password—this password is used to encrypt your file using strong encryption algorithms.</p>
                            <p class="text-2xl leading-snug">Your file is never stored in plain text and is protected from unauthorized access at all times.</p>
                        </div>
                    </div>
                </div>
                <!-- Step 2: Image center, text below -->
                <div class="flex flex-col md:flex-row-reverse w-full items-center">
                    <div class="md:w-1/2 flex items-center justify-center min-h-[420px] bg-[#5B88B2] md:rounded-none rounded-t-3xl overflow-hidden relative">
                        <div class="absolute inset-0 w-full h-full bg-[#5B88B2]"></div>
                        <img src="/undraw_share-link_jr6w.svg" alt="Share & Manage"
                             class="h-[320px] w-auto mx-auto object-contain relative z-10" style="border-radius:0;">
                    </div>
                    <div class="md:w-1/2 bg-[#FBF9E4] flex flex-col justify-center p-16 text-[#122C4F]">
                        <div class="max-w-2xl mx-auto flex flex-col">
                            <h3 class="font-bold text-4xl mb-8" style="font-family: 'Montserrat', 'Inter', sans-serif;">2. Share & Manage</h3>
                            <p class="mb-6 text-2xl leading-snug">Share your encrypted files with friends by adding their usernames, or generate a public link for anyone to access (if you choose).</p>
                            <p class="text-2xl leading-snug">Manage permissions easily—add or remove users, and control who can view, download, or edit your files at any time.</p>
                        </div>
                    </div>
                </div>
                <!-- Step 3: Image center, text below -->
                <div class="flex flex-col md:flex-row w-full items-center">
                    <div class="md:w-1/2 flex items-center justify-center min-h-[420px] bg-[#5B88B2] md:rounded-none rounded-t-3xl overflow-hidden relative">
                        <div class="absolute inset-0 w-full h-full bg-[#5B88B2]"></div>
                        <img src="/undraw_enter-password_1kl4.svg" alt="Access Control"
                             class="h-[320px] w-auto mx-auto object-contain relative z-10" style="border-radius:0;">
                    </div>
                    <div class="md:w-1/2 bg-[#FBF9E4] flex flex-col justify-center p-16 text-[#122C4F]">
                        <div class="max-w-2xl mx-auto flex flex-col">
                            <h3 class="font-bold text-4xl mb-8" style="font-family: 'Montserrat', 'Inter', sans-serif;">3. Access Control</h3>
                            <p class="mb-6 text-2xl leading-snug">To download a file, users must enter the correct password. Only then is the file decrypted and made available for download.</p>
                            <p class="text-2xl leading-snug">This ensures that even if someone obtains the file link, they cannot access its contents without your password.</p>
                        </div>
                    </div>
                </div>
                <!-- Step 4: Image center, text below -->
                <div class="flex flex-col md:flex-row-reverse w-full items-center">
                    <div class="md:w-1/2 flex items-center justify-center min-h-[420px] bg-[#5B88B2] md:rounded-none rounded-t-3xl overflow-hidden relative">
                        <div class="absolute inset-0 w-full h-full bg-[#5B88B2]"></div>
                        <img src="/undraw_social-interaction_6fi7.svg" alt="Logs, Comments & Friends"
                             class="h-[320px] w-auto mx-auto object-contain relative z-10" style="border-radius:0;">
                    </div>
                    <div class="md:w-1/2 bg-[#FBF9E4] flex flex-col justify-center p-16 text-[#122C4F]">
                        <div class="max-w-2xl mx-auto flex flex-col">
                            <h3 class="font-bold text-4xl mb-8" style="font-family: 'Montserrat', 'Inter', sans-serif;">4. Logs, Comments & Friends</h3>
                            <p class="mb-6 text-2xl leading-snug">Every file has a detailed log of interactions, so you can see who accessed or commented on your files. Admins can view IP addresses for extra security.</p>
                            <p class="text-2xl leading-snug">Send friend requests, comment on files, and manage your sharing network with ease.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endguest




    
</x-layout>

