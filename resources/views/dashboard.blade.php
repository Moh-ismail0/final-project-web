@extends('layouts.admin')

@section('title', 'Dashboard')
@section('main-title', 'Dashboard')
@section('sub-title', 'Dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">

        <div class="card p-4" style="display:flex; flex-direction:row; justify-content:space-between; align-items:center;">
            <div>
                <h2><i class="fa-solid fa-user-tie"></i> Welcome, {{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : Auth::user()->name }}!</h2>
                <p class="m-0">This is your task management dashboard.</p>
            </div>
            <img src="{{ asset('asset/906343.png') }}" style="width:120px; opacity:0.8;">
        </div>


        <div class="row mb-3">
    <div class="col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $completed }}</h3>
                <p>Completed Tasks</p>
            </div>
            <div class="icon"><i class="fas fa-check"></i></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $total - $completed }}</h3>
                <p>Pending Tasks</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
        </div>
    </div>
</div>

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Recent Tasks</h3>
    <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm">View All Tasks</a>
</div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Owner</th>
                            <th>Due Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->title }}</td>
                            <td>
                               <span class="badge badge-{{ $task->status == 'Completed' ? 'success' : 'warning' }}">
                                {{ $task->status }}
                             </span>
                           </td>
                            <td>{{ $task->category->name ?? '-' }}</td>
                            <td>{{ $task->user->name ?? 'Admin' }}</td>
                           <td>
    @if($task->due_date)
        @php
            $diff = (int) now()->diffInDays($task->due_date, false);
        @endphp

        @if($diff < 0)
            <span class="badge badge-danger">
                <i class="fas fa-times-circle"></i> Overdue
            </span>
        @elseif($diff == 0)
            <span class="badge badge-warning blink">
                <i class="fas fa-exclamation-circle"></i> Today!
            </span>
        @elseif($diff <= 2)
            <span class="badge badge-warning blink">
                <i class="fas fa-clock"></i> {{ $diff }} day(s) left
            </span>
        @else
            <span class="badge badge-info">
                <i class="fas fa-calendar"></i> {{ $diff }} days left
            </span>
        @endif
    @else
        <span class="text-muted">-</span>
    @endif
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align:center;">
                                No tasks yet. <a href="{{ route('tasks.create') }}">Add one!</a>
                            </td>

                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<!-- Last update: 2026-04-20 -->
@endsection
