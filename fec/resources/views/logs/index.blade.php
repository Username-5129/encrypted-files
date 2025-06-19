<x-layout>
    <x-slot name="title">
        Activity Logs
    </x-slot>

    <div class="relative min-h-screen bg-gradient-to-br from-[#122C4F] via-[#1e3a5c] to-black py-12 px-4 overflow-hidden">

        <svg class="absolute top-0 left-0 w-80 h-80 opacity-20 pointer-events-none" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="100" fill="#5B88B2"/>
        </svg>
        <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-10 pointer-events-none" viewBox="0 0 200 200">
            <rect width="200" height="200" rx="100" fill="#FBF9E4"/>
        </svg>

        <div class="relative max-w-5xl mx-auto mt-16">
            <div class="bg-[#1e3a5c]/90 border border-[#5B88B2] rounded-2xl shadow-2xl p-10">
                <h1 class="text-3xl font-extrabold text-[#FBF9E4] mb-6 flex items-center gap-2">
                    <svg class="w-7 h-7 text-[#5B88B2]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4M4 11h16"/>
                    </svg>
                    {{ __('logs.activity_logs') }}
                </h1>
                <div id="clock" class="text-[#BFD7ED] mb-6"></div>

                @if ($logs->isEmpty())
                    <div class="bg-[#FBF9E4] text-[#122C4F] px-4 py-3 rounded shadow text-center mb-6">
                        No logs available.
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg shadow mb-6">
                        <table class="min-w-full bg-[#122C4F] text-[#FBF9E4] rounded-lg">
                            <thead>
                                <tr class="bg-[#5B88B2]/80 text-[#FBF9E4]">
                                    <th class="px-4 py-3 text-left">File ID</th>
                                    <th class="px-4 py-3 text-left">User ID</th>
                                    @auth
                                    @if (Auth::user()->isAdmin())
                                        <th class="px-4 py-3 text-left">IP Address</th>
                                    @endif
                                    @endauth
                                    <th class="px-4 py-3 text-left">Action</th>
                                    <th class="px-4 py-3 text-left">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                <tr class="border-b border-[#5B88B2]/40 hover:bg-[#1e3a5c]/60 transition">
                                    <td class="px-4 py-2">{{ $log->file_id ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $log->user_id ?? 'N/A' }}</td>
                                    @auth
                                    @if (Auth::user()->isAdmin())
                                        <td class="px-4 py-2">{{ $log->ip_address ?? 'N/A' }}</td>
                                    @endif
                                    @endauth
                                    <td class="px-4 py-2">{{ $log->action }}</td>
                                    <td class="px-4 py-2">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $logs->links() }}
                    </div>
                @endif

                <a href="{{ route('home') }}"
                   class="inline-block mt-4 bg-[#5B88B2] text-[#FBF9E4] px-6 py-2 rounded-xl shadow hover:bg-[#49709a] transition font-semibold">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-layout>