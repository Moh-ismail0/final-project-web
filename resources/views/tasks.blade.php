@extends('layouts.admin')

@section('title', 'Tasks')
@section('main-title', 'Tasks')
@section('sub-title', 'All Tasks')

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">All Tasks</h3>
    <div>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm mr-2">
            <i class="fas fa-plus"></i> Add Task
        </a>
        <button class="btn btn-danger btn-sm" onclick="destroyAll()">
            <i class="fas fa-trash"></i> Delete All
        </button>
        <a href="{{ route('tasks.trashed') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-trash"></i> Trashed
                    </a>
    </div>
</div>
            <div class="card-body">
                <form method="GET" action="{{ route('tasks.index') }}" style="display:flex; gap:10px;">
                    <select name="status" class="form-control" style="width:200px;">
                        <option value="">All Tasks</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>

                    </select>
                    <button class="btn btn-primary" type="submit">Filter</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Owner</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($tasks as $task)
                    <tr id="task-{{ $task->id }}">
    <td>{{ $task->id }}</td>
    <td>{{ $task->title }}</td>
    <td>{{ $task->description }}</td>
    <td>{{ $task->status }}</td>
    <td>{{ $task->category->name ?? '-' }}</td>
    <td>{{ $task->user->name ?? '-' }}</td>
    <td style="color: {{ $task->due_date && \Carbon\Carbon::parse($task->due_date)->isPast() ? 'red' : 'inherit' }}">
        {{ $task->due_date ?? '-' }}
    </td>

    <td>

        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-success btn-sm">Edit</a>
        <button class="btn btn-danger btn-sm" onclick="performDestroy({{ $task->id }}, this)">Delete</button>
        <button class="btn btn-info btn-sm" onclick="toggleComments({{ $task->id }})">
            <i class="fas fa-comments"></i> Comments ({{ $task->comments->count() }})
        </button>

    </td>
                    </tr>

{{-- Comments Row --}}
<tr id="comments-{{ $task->id }}" style="display:none;">
    <td colspan="8">
        <div class="p-3">

            <div id="comments-list-{{ $task->id }}">
                @foreach($task->comments as $comment)
                <div class="d-flex justify-content-between align-items-center mb-2 p-2"
                     style="background:#f8f9fa; border-radius:5px;"
                     id="comment-{{ $comment->id }}">
                    <span>{{ $comment->body }}</span>
                    <button class="btn btn-danger btn-sm"
                            onclick="deleteComment({{ $comment->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                @endforeach
            </div>

            {{-- إضافة تعليق --}}
            <div class="d-flex gap-2 mt-2">
                <input type="text" id="comment-input-{{ $task->id }}"
                       class="form-control" placeholder="Add a comment...">
                <button class="btn btn-primary btn-sm"
                        onclick="addComment({{ $task->id }})">Add</button>
            </div>
        </div>
    </td>
</tr>
@empty
                        <tr>
                            <td colspan="6" class="text-center">No tasks yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $tasks->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function performDestroy(id, reference) {
        confirmDestroy('/dashboard/tasks/' + id, reference);
    }

    function destroyAll() {
        Swal.fire({
            title: 'Delete All Tasks?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/dashboard/tasks/destroy-all')
                    .then(function(response) {
                        showMessage(response.data);
                        setTimeout(() => location.reload(), 1500);
                    });
            }
        });
    }

    function toggleComments(taskId) {
        let row = document.getElementById('comments-' + taskId);
        row.style.display = row.style.display === 'none' ? '' : 'none';
    }

</script>
@endsection
