@extends('layouts.app')
@section('title', 'Welcome')
@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">
                        @lang('lang.text_welcome_title')
                    </h1>
                </div>
                <div class="card-body">
                @lang('lang.text_welcome_paragraph')

                {!!trans('lang.text_welcome_paragraph')!!}
                </div>
                <div class="card-footer text-center">
                    <a href="{{route('task.index')}}" class="btn btn-primary">@lang('lang.text_go_todo')</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection