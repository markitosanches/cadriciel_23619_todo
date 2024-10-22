@extends('layouts.app')
@section('title', 'Task')
@section('content')
<div class="container">
    <h1 class="mt-5 mb-4">Task</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">{{ $task->title}}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $task->description}}</p>
                    <ul class="list-unstyled">
                        <li><strong>Completed: </strong> {{ $task->completed ? "Yes" : "No"}}</li>
                        <li><strong>Due Date: </strong>{{ $task->due_date}}</li>
                        <li><strong>Author: </strong>{{ $task->user_id}}</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{route('task.edit', $task->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                        <form action="{{route('task.destroy', $task->id)}}" method="post">
                            @csrf
                            @method('delete') 
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection   