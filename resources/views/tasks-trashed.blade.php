@extends('layouts.admin')

@section('title', 'Trashed Tasks')
@section('main-title', 'Trashed Tasks')
@section('sub-title', 'Trashed Tasks')

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h3 class="card-title">Trashed Tasks</h3>
    <div>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm mr-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <button class="btn btn-success btn-sm mr-2" onclick="restoreAll()">
            <i class="fas fa-undo"></i> Restore All
        </button>
        <button class="btn btn-danger btn-sm" onclick="forceDeleteAll()">
            <i class="fas fa-trash"></i> Delete All Forever
        </button>
    </div>
</div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Owner</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr id="task-{{ $task->id }}">
                            <td>{{ $task->title }}</td>
                            <td>
                                <span class="badge badge-{{ $task->status == 'completed' ? 'success' : 'warning' }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td>{{ $task->category->name ?? '-' }}</td>
                            <td>{{ $task->user->name ?? '-' }}</td>
                            <td>{{ $task->deleted_at->format('Y-m-d') }}</td>
                            <td>

                                <button class="btn btn-success btn-sm" onclick="performRestore({{ $task->id }}, this)">Restore</button>
                                <button class="btn btn-danger btn-sm" onclick="performForceDelete({{ $task->id }}, this)">Delete Forever</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No trashed tasks.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>

    function performForceDelete(id, reference) {
        confirmDestroy('/dashboard/tasks/' + id + '/force-delete', reference);
    }


</script>
@endsection
