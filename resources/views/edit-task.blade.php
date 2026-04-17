@extends('layouts.admin')

@section('title', 'Edit Task')
@section('main-title', 'Edit Task')
@section('sub-title', 'Edit Task')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Task</h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" id="title" class="form-control" value="{{ $task->title }}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea id="description" class="form-control">{{ $task->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select id="status" class="form-control">
                        <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select id="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $task->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Due Date</label>
                    <input type="date" id="due_date" class="form-control" value="{{ $task->due_date }}">
                </div>

                <button type="button" class="btn btn-primary" onclick="submitUpdate()">Update Task</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function submitUpdate() {
    let formData = new FormData();
    formData.append('title', document.getElementById('title').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('status', document.getElementById('status').value);
    formData.append('category_id', document.getElementById('category_id').value);
    formData.append('due_date', document.getElementById('due_date').value);
    storeWithValidation('/dashboard/tasks_update/{{ $task->id }}', formData);
}
</script>

@endsection
