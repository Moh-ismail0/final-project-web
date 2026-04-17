@extends('layouts.admin')

@section('title', 'Add Task')
@section('main-title', 'Add Task')
@section('sub-title', 'Add Task')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Task</h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" id="title" class="form-control">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea id="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select id="status" class="form-control">
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select id="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Due Date</label>
                    <input type="date" id="due_date" class="form-control">
                </div>

                <button type="button" class="btn btn-primary" onclick="submitForm()">Add Task</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function submitForm() {
    let formData = new FormData();
    formData.append('title', document.getElementById('title').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('status', document.getElementById('status').value);
    formData.append('category_id', document.getElementById('category_id').value);
    formData.append('due_date', document.getElementById('due_date').value);
    storeWithValidation('/dashboard/tasks', formData);
}
</script>
@endsection
