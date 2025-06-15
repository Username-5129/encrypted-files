<x-layout>
    <x-slot name="title">
        Home
    </x-slot>

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
            <!-- Example illustration (undraw.co) -->
            <img src="https://undraw.co/api/illustrations/secure_files.svg" alt="Secure Files" class="w-60 mt-10 object-contain transition-transform duration-300 hover:scale-105" />
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
    <section id="about" class="py-20 bg-[#5B88B2]">
        <div class="max-w-5xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-[#122C4F] mb-12 text-center">How does it work?</h2>
            <div class="flex flex-col gap-12">
                <!-- Step 1 -->
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="md:w-1/2 bg-[#FBF9E4] rounded-2xl shadow-lg p-8 text-[#122C4F]">
                        <h3 class="font-bold text-xl mb-2">1. Upload & Encrypt</h3>
                        <p>Upload your files and set a password. Files are encrypted and stored securely.</p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <!-- Placeholder for your image/illustration -->
                        <div class="w-48 h-48 bg-[#122C4F] rounded-xl flex items-center justify-center">
                            <span class="text-[#FBF9E4] text-4xl">🔒</span>
                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="flex flex-col md:flex-row-reverse items-center gap-8">
                    <div class="md:w-1/2 bg-[#FBF9E4] rounded-2xl shadow-lg p-8 text-[#122C4F]">
                        <h3 class="font-bold text-xl mb-2">2. Share & Manage</h3>
                        <p>Share files with friends or make them public. Add users by name or share a public link.</p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <div class="w-48 h-48 bg-[#122C4F] rounded-xl flex items-center justify-center">
                            <span class="text-[#FBF9E4] text-4xl">🤝</span>
                        </div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="md:w-1/2 bg-[#FBF9E4] rounded-2xl shadow-lg p-8 text-[#122C4F]">
                        <h3 class="font-bold text-xl mb-2">3. Access Control</h3>
                        <p>Only users with the correct password can decrypt and download files.</p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <div class="w-48 h-48 bg-[#122C4F] rounded-xl flex items-center justify-center">
                            <span class="text-[#FBF9E4] text-4xl">🔑</span>
                        </div>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="flex flex-col md:flex-row-reverse items-center gap-8">
                    <div class="md:w-1/2 bg-[#FBF9E4] rounded-2xl shadow-lg p-8 text-[#122C4F]">
                        <h3 class="font-bold text-xl mb-2">4. Logs, Comments & Friends</h3>
                        <p>View file logs, comment on files, manage permissions, and easily add friends to file access.</p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <div class="w-48 h-48 bg-[#122C4F] rounded-xl flex items-center justify-center">
                            <span class="text-[#FBF9E4] text-4xl">💬</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
