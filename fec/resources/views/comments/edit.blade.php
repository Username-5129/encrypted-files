<x-layout>
    <x-slot name="title">
        Edit Comment
    </x-slot>
<div class="container">
    <h1>Edit Comment</h1>

    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="content">Comment:</label>
            <textarea name="content" id="content" rows="3" required class="form-control">{{ $comment->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Comment</button>
    </form>
</div>

</x-layout>