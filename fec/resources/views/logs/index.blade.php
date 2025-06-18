<x-layout>
    <x-slot name="title">
        Activity Logs
    </x-slot>

    <h1>Activity Logs</h1>

    @if ($logs->isEmpty())
        <div class="alert alert-info">No logs available.</div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>File ID</th>
                    <th>User ID</th>
                    @auth
                    @if (Auth::user()->isAdmin())
                        <th>IP Address</th>
                    @endif
                    @endauth
                    <th>Action</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->file_id ?? 'N/A' }}</td>
                    <td>{{ $log->user_id ?? 'N/A' }}</td>
                    @auth
                    @if (Auth::user()->isAdmin())
                        <td>{{ $log->ip_address ?? 'N/A' }}</td>
                    @endif
                    @endauth
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $logs->links() }}
        </div>
    @endif

    <a href="{{ route('home') }}" class="btn btn-secondary">Back to Dashboard</a>
</x-layout>