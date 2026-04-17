@extends('layouts.admin')

@section('title', 'Categories')
@section('main-title', 'Categories')
@section('sub-title', 'All Categories')

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Category</h3>
            </div>
            <div class="card-body">
            <div style="display:flex; gap:10px;">
    <input type="text" id="category_name" class="form-control" placeholder="e.g. Study" style="width:300px;">
    <button class="btn btn-primary" onclick="submitCategory()">Add</button>
</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Categories</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr id="category-{{ $category->id }}">
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="performDestroy({{ $category->id }}, this)">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No categories yet.</td>
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
    function performDestroy(id, reference) {
        confirmDestroy('/dashboard/categories/' + id, reference);
    }
    function submitCategory() {
    let formData = new FormData();
    formData.append('name', document.getElementById('category_name').value);
    addCategory('{{ route("categories.store") }}', formData);
}
</script>
@endsection
