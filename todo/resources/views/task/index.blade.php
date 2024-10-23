@extends('layouts.app')
@section('title', 'Task List')
@section('content')
<div class="container">
    <h1 class="mt-5 mb-4">Task List</h1>
    <div class="row">
        @forelse($tasks as $task)
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">{{ $task->title}}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $task->description}}</p>
                    <ul class="list-unstyled">
                        <li><strong>Completed: </strong> {{ $task->completed ? "Yes" : "No"}}</li>
                        <li><strong>Due Date: </strong>{{ $task->due_date}}</li>
                        <li><strong>Author: </strong>{{ $task->user->name}}</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="{{route('task.show', $task->id)}}" class="btn btn-sm btn-outline-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p class="alert alert-danger">There is no task</p>
        @endforelse
    </div>
</div>
@endsection   