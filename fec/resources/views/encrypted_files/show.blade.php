<x-layout>
    <x-slot name="title">
        {{ $file->title }}
    </x-slot>

    <h1>{{ $file->title }}</h1>
    <p><strong>filename:</strong> {{ $file->filename }}</p>
    <p><strong>Description:</strong> {{ $file->description }}</p>
    <p><strong>Salary:</strong> ${{ number_format($file->salary, 2) }}</p>
    <p><strong>Category:</strong> {{ $file->jobCategory->category }}</p>
    <p><strong>Employment Type:</strong> {{ $file->employmentType->category }}</p>

    @can('update', $file)
    <a href="{{ route('file.edit', $file->id) }}" class="btn btn-primary">Edit file</a>
    <br>
    @endcan
    <a href="{{ route('file.index') }}" class="btn btn-secondary">Back to files</a>

    @can('delete', $file)
    <form action="{{ route('file.destroy', $file) }}" method="POST" onsubmit="return
        confirm('Are you sure you want to delete this job file?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    @endcan

    <hr>

    @auth
        @php
            $application = $file->applications()->where('user_id', auth()->id())->first();
        @endphp

        @if(!$application)
            <h4>Apply for this job</h4>
            @if ($errors->has('cover_letter'))
                <div class="alert alert-danger">
                    {{ $errors->first('cover_letter') }}
                </div>
            @endif
            <form method="POST" action="{{ route('file.apply', $file) }}">
                @csrf
                <div class="mb-3">
                    <label for="cover_letter" class="form-label">Cover Letter</label>
                    <textarea name="cover_letter" id="cover_letter" class="form-control" rows="5" required>{{ old('cover_letter') }}</textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit Application</button>
            </form>
        @else
            <h4>Your Application</h4>
            <div class="alert alert-info">
                <strong>Cover Letter:</strong><br>
                {{ $application->cover_letter }}
            </div>
        @endif
    @else
        <div class="alert alert-warning">
            Please <a href="{{ route('login') }}">log in</a> to apply for this job.
        </div>
    @endauth

    {{-- Optional: Show applications to job owner or admin --}}
    @can('delete', $file)
        <hr>
        <h4>Applications for this job</h4>
        @php
            $applications = $file->applications;
        @endphp
        @if($applications->isEmpty())
            <div class="alert alert-info">No applications yet.</div>
        @else
            <ul class="list-group mb-3">
                @foreach($applications as $app)
                    <li class="list-group-item">
                        <strong>User:</strong> {{ $app->user->name ?? 'Unknown' }}<br>
                        <strong>Cover Letter:</strong><br>
                        {{ $app->cover_letter }}
                    </li>
                @endforeach
            </ul>
        @endif
    @endcan

</x-layout>