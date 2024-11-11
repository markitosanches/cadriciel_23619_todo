@extends('layouts.app')
@section('title', 'Category')
@section('content')
    @if(!$errors->isEmpty())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>     
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>                
    @endif
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Category</h5>
                </div>
                <div class="card-body">
                    <form  method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="category_en" class="form-label">Category in English</label>
                                <input type="text" class="form-control" id="category_en" name="category_en"  value="{{old('category_en')}}">
                        </div>
                        <div class="mb-3">
                            <label for="category_fr" class="form-label">Category in French</label>
                                <input type="text" class="form-control" id="category_fr" name="category_fr"  value="{{old('category_fr')}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection