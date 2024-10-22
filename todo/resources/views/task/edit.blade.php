@extends('layouts.app')
@section('title', 'Edit Task')
@section('content')

    <h1 class="mt-5 mb-4">Edit Task</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Edit Task</h5>
                </div>
                    <div class="card-body">
                    <form action="{{ route('task.update', $task->id)}}" method="post">
                    @csrf
                    @method('put')
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title', $task->title)}}">
                            @if($errors->has('title'))
                                <div class="text-danger">
                                    {{$errors->first('title')}}
                               </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description">{{old('description', $task->description)}}</textarea>
                            @if($errors->has('description'))
                                <div class="text-danger">
                                    {{$errors->first('description')}}
                               </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="completed" class="form-check-label">Completed</label>
                            <input type="checkbox" class="form-check-input" id="completed" name="completed" value="1" {{old('completed', $task->completed) ? 'checked': ''}}>
                            @if($errors->has('completed'))
                                <div class="text-danger">
                                    {{$errors->first('completed')}}
                               </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{old('due_date', $task->due_date)}}">
                            @if($errors->has('due_date'))
                                <div class="text-danger">
                                    {{$errors->first('due_date')}}
                               </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                    </div>             
            </div>
        </div>
    </div>

@endsection   